<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "../includes/config.php";

// Initialize variables
$search = "";
$where = "1";

// Handle search
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    $search = trim($_GET["search"]);
    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $where = "(fname LIKE '%$search%' OR lname LIKE '%$search%' OR phone LIKE '%$search%')";
    }
}

// Delete member
if (isset($_GET["delete"]) && !empty($_GET["delete"])) {
    $p_no = mysqli_real_escape_string($conn, $_GET["delete"]);
    $sql = "DELETE FROM people WHERE p_no = '$p_no'";
    mysqli_query($conn, $sql);
    header("location: members.php");
    exit;
}

// Fetch members with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM people WHERE role = 'member' AND $where ORDER BY created_at DESC LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $sql);

// Get total records for pagination
$sql = "SELECT FOUND_ROWS() as total";
$total_result = mysqli_query($conn, $sql);
$total_records = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members - Somali Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Members Management</h2>
            <a href="members.php?action=add" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Add New Member
            </a>
        </div>

        <!-- Search Form -->
        <form action="members.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name or phone..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>

        <!-- Members Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Membership End</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['p_no']); ?></td>
                                <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $row['status'] == 'active' ? 'success' : 'danger'; ?>">
                                        <?php echo ucfirst(htmlspecialchars($row['status'])); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['membership_end']); ?></td>
                                <td>
                                    <a href="members.php?action=edit&id=<?php echo $row['p_no']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="measurements.php?member_id=<?php echo $row['p_no']; ?>" class="btn btn-sm btn-success">
                                        <i class="fas fa-weight"></i>
                                    </a>
                                    <a href="payments.php?member_id=<?php echo $row['p_no']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-dollar-sign"></i>
                                    </a>
                                    <a href="members.php?delete=<?php echo $row['p_no']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this member?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
