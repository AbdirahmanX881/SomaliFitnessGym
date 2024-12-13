<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include database connection
require_once "../includes/config.php";

// Initialize statistics array
$stats = [
    'total_members' => 0,
    'active_members' => 0,
    'new_members' => 0,
    'monthly_revenue' => 0
];

try {
    // Total members
    $sql = "SELECT COUNT(*) as total FROM people WHERE role = 'member'";
    if ($result = mysqli_query($conn, $sql)) {
        $stats['total_members'] = mysqli_fetch_assoc($result)['total'] ?? 0;
        mysqli_free_result($result);
    }

    // Active members
    $sql = "SELECT COUNT(*) as active FROM people WHERE role = 'member' AND status = 'active' AND membership_end >= CURDATE()";
    if ($result = mysqli_query($conn, $sql)) {
        $stats['active_members'] = mysqli_fetch_assoc($result)['active'] ?? 0;
        mysqli_free_result($result);
    }

    // New members this month
    $sql = "SELECT COUNT(*) as new FROM people WHERE role = 'member' AND MONTH(created_at) = MONTH(CURRENT_DATE())";
    if ($result = mysqli_query($conn, $sql)) {
        $stats['new_members'] = mysqli_fetch_assoc($result)['new'] ?? 0;
        mysqli_free_result($result);
    }

    // Total payments this month
    $sql = "SELECT COALESCE(SUM(amount), 0) as total FROM receipts WHERE MONTH(created_at) = MONTH(CURRENT_DATE())";
    if ($result = mysqli_query($conn, $sql)) {
        $stats['monthly_revenue'] = mysqli_fetch_assoc($result)['total'] ?? 0;
        mysqli_free_result($result);
    }

    // Recent activities
    $sql = "SELECT r.*, p.fname, p.lname 
            FROM receipts r 
            JOIN people p ON r.p_no = p.p_no 
            ORDER BY r.created_at DESC LIMIT 5";
    $recent_activities = mysqli_query($conn, $sql);

} catch (Exception $e) {
    error_log("Dashboard Error: " . $e->getMessage());
    $error = "An error occurred while loading the dashboard. Please try again later.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Somali Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .stat-card {
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .quick-action-btn {
            width: 100%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Members</h5>
                        <h3><?php echo $stats['total_members']; ?></h3>
                        <p class="card-text"><i class="fas fa-users"></i> All registered members</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Active Members</h5>
                        <h3><?php echo $stats['active_members']; ?></h3>
                        <p class="card-text"><i class="fas fa-user-check"></i> Current active memberships</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Monthly Revenue</h5>
                        <h3>$<?php echo number_format($stats['monthly_revenue'], 2); ?></h3>
                        <p class="card-text"><i class="fas fa-dollar-sign"></i> This month's earnings</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">New Members</h5>
                        <h3><?php echo $stats['new_members']; ?></h3>
                        <p class="card-text"><i class="fas fa-user-plus"></i> Joined this month</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <a href="members.php?action=add" class="btn btn-primary quick-action-btn">
                            <i class="fas fa-user-plus"></i> Add New Member
                        </a>
                        <a href="payments.php?action=add" class="btn btn-success quick-action-btn">
                            <i class="fas fa-cash-register"></i> Record Payment
                        </a>
                        <a href="measurements.php?action=add" class="btn btn-info quick-action-btn">
                            <i class="fas fa-weight"></i> Record Measurements
                        </a>
                        <a href="attendance.php" class="btn btn-warning quick-action-btn">
                            <i class="fas fa-clipboard-check"></i> Mark Attendance
                        </a>
                        <a href="reports.php" class="btn btn-secondary quick-action-btn">
                            <i class="fas fa-chart-bar"></i> View Reports
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Recent Activities</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php
                            if ($recent_activities && mysqli_num_rows($recent_activities) > 0) {
                                while ($row = mysqli_fetch_assoc($recent_activities)) {
                                    echo '<div class="list-group-item">';
                                    echo '<div class="d-flex w-100 justify-content-between">';
                                    echo '<h6 class="mb-1">' . htmlspecialchars($row['fname'] . ' ' . $row['lname']) . '</h6>';
                                    echo '<small>' . date('M d, Y', strtotime($row['created_at'])) . '</small>';
                                    echo '</div>';
                                    echo '<p class="mb-1">Paid $' . number_format($row['amount'], 2) . '</p>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p class="text-muted">No recent activities</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
