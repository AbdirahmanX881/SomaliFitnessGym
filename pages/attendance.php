<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "../includes/config.php";

// Handle check-in/check-out
$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);

    // Check if member exists
    $sql = "SELECT * FROM people WHERE p_no = '$member_id' AND role = 'member'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        if ($action == 'check_in') {
            // Check if already checked in today
            $sql = "SELECT * FROM attendance 
                    WHERE p_no = '$member_id' 
                    AND DATE(check_in) = CURDATE() 
                    AND check_out IS NULL";
            $check_result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($check_result) == 0) {
                // Perform check-in
                $sql = "INSERT INTO attendance (p_no, check_in) VALUES ('$member_id', NOW())";
                if (mysqli_query($conn, $sql)) {
                    $message = "Member checked in successfully!";
                    $message_type = "success";
                } else {
                    $message = "Error checking in: " . mysqli_error($conn);
                    $message_type = "danger";
                }
            } else {
                $message = "Member is already checked in today!";
                $message_type = "warning";
            }
        } elseif ($action == 'check_out') {
            // Find the most recent check-in without a check-out
            $sql = "UPDATE attendance 
                    SET check_out = NOW() 
                    WHERE p_no = '$member_id' 
                    AND DATE(check_in) = CURDATE() 
                    AND check_out IS NULL 
                    ORDER BY check_in DESC 
                    LIMIT 1";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Member checked out successfully!";
                $message_type = "success";
            } else {
                $message = "Error checking out: " . mysqli_error($conn);
                $message_type = "danger";
            }
        }
    } else {
        $message = "Member not found!";
        $message_type = "danger";
    }
}

// Fetch today's attendance
$today_attendance = [];
$sql = "SELECT a.*, p.fname, p.lname 
        FROM attendance a
        JOIN people p ON a.p_no = p.p_no
        WHERE DATE(a.check_in) = CURDATE()
        ORDER BY a.check_in DESC";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $today_attendance[] = $row;
}

// Fetch all members for dropdown
$members = [];
$sql = "SELECT p_no, CONCAT(fname, ' ', lname) as full_name 
        FROM people 
        WHERE role = 'member' 
        ORDER BY fname, lname";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $members[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - Somali Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Attendance Management</h1>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Check In/Out</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="member_id" class="form-label">Select Member</label>
                                        <select name="member_id" class="form-control" required>
                                            <option value="">Choose a member</option>
                                            <?php foreach ($members as $member): ?>
                                                <option value="<?php echo $member['p_no']; ?>">
                                                    <?php echo htmlspecialchars($member['full_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="action" value="check_in" class="btn btn-success">
                                            <i class="fas fa-sign-in-alt me-2"></i>Check In
                                        </button>
                                        <button type="submit" name="action" value="check_out" class="btn btn-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Check Out
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Today's Attendance</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Member</th>
                                                <th>Check In</th>
                                                <th>Check Out</th>
                                                <th>Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($today_attendance as $attendance): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($attendance['fname'] . ' ' . $attendance['lname']); ?></td>
                                                    <td><?php echo date('H:i:s', strtotime($attendance['check_in'])); ?></td>
                                                    <td>
                                                        <?php 
                                                        if ($attendance['check_out']) {
                                                            echo date('H:i:s', strtotime($attendance['check_out']));
                                                        } else {
                                                            echo '<span class="badge bg-warning">Active</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if ($attendance['check_out']) {
                                                            $duration = strtotime($attendance['check_out']) - strtotime($attendance['check_in']);
                                                            echo gmdate("H:i:s", $duration);
                                                        } else {
                                                            echo '-';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
