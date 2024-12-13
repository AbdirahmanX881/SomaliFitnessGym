<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "../includes/config.php";

// Initialize variables
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

// Fetch summary statistics
$stats = [
    'total_revenue' => 0,
    'new_members' => 0,
    'active_members' => 0,
    'expired_members' => 0
];

// Total revenue
$sql = "SELECT COALESCE(SUM(amount), 0) as total 
        FROM receipts 
        WHERE created_at BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($conn, $sql);
$stats['total_revenue'] = mysqli_fetch_assoc($result)['total'];

// New members
$sql = "SELECT COUNT(*) as total 
        FROM people 
        WHERE role = 'member' 
        AND created_at BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($conn, $sql);
$stats['new_members'] = mysqli_fetch_assoc($result)['total'];

// Active members
$sql = "SELECT COUNT(*) as total 
        FROM people 
        WHERE role = 'member' 
        AND status = 'active' 
        AND membership_end >= CURDATE()";
$result = mysqli_query($conn, $sql);
$stats['active_members'] = mysqli_fetch_assoc($result)['total'];

// Expired members
$sql = "SELECT COUNT(*) as total 
        FROM people 
        WHERE role = 'member' 
        AND (status = 'inactive' OR membership_end < CURDATE())";
$result = mysqli_query($conn, $sql);
$stats['expired_members'] = mysqli_fetch_assoc($result)['total'];

// Fetch payment history
$sql = "SELECT r.*, p.fname, p.lname 
        FROM receipts r 
        JOIN people p ON r.p_no = p.p_no 
        WHERE r.created_at BETWEEN '$start_date' AND '$end_date' 
        ORDER BY r.created_at DESC";
$payments = mysqli_query($conn, $sql);

// Fetch membership expiry list
$sql = "SELECT p_no, fname, lname, membership_end 
        FROM people 
        WHERE role = 'member' 
        AND membership_end BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY) 
        ORDER BY membership_end";
$expiring = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Somali Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Reports & Analytics</h2>

        <!-- Date Range Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="<?php echo $start_date; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="<?php echo $end_date; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary d-block">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <h3>$<?php echo number_format($stats['total_revenue'], 2); ?></h3>
                        <p class="card-text"><i class="fas fa-dollar-sign"></i> Period earnings</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">New Members</h5>
                        <h3><?php echo $stats['new_members']; ?></h3>
                        <p class="card-text"><i class="fas fa-user-plus"></i> New registrations</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Active Members</h5>
                        <h3><?php echo $stats['active_members']; ?></h3>
                        <p class="card-text"><i class="fas fa-user-check"></i> Current members</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Expired Members</h5>
                        <h3><?php echo $stats['expired_members']; ?></h3>
                        <p class="card-text"><i class="fas fa-user-clock"></i> Inactive members</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Payment History -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Payment History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Member</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($payments)): ?>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></td>
                                        <td>$<?php echo number_format($row['amount'], 2); ?></td>
                                        <td><?php echo ucfirst($row['payment_type']); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expiring Memberships -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Expiring Memberships</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php while ($row = mysqli_fetch_assoc($expiring)): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></h6>
                                    <small class="text-muted"><?php echo date('M d, Y', strtotime($row['membership_end'])); ?></small>
                                </div>
                                <p class="mb-1">
                                    <small class="text-danger">
                                        Expires in <?php echo ceil((strtotime($row['membership_end']) - time()) / (60*60*24)); ?> days
                                    </small>
                                </p>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
