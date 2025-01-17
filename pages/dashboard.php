<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "../includes/config.php";

// Fetch key statistics
$stats = [
    'total_members' => 0,
    'active_members' => 0,
    'new_members_this_month' => 0,
    'total_revenue' => 0,
    'attendance_today' => 0,
    'expiring_memberships' => 0
];

// Total Members
$sql = "SELECT COUNT(*) as total FROM people WHERE role = 'member'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $stats['total_members'] = mysqli_fetch_assoc($result)['total'];
} else {
    echo "Error: " . mysqli_error($conn);
}

// Active Members
$sql = "SELECT COUNT(*) as total FROM people WHERE role = 'member' AND status = 'active' AND membership_end >= CURDATE()";
$result = mysqli_query($conn, $sql);
if ($result) {
    $stats['active_members'] = mysqli_fetch_assoc($result)['total'];
} else {
    echo "Error: " . mysqli_error($conn);
}

// New Members This Month
$sql = "SELECT COUNT(*) as total FROM people WHERE role = 'member' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$result = mysqli_query($conn, $sql);
if ($result) {
    $stats['new_members_this_month'] = mysqli_fetch_assoc($result)['total'];
} else {
    echo "Error: " . mysqli_error($conn);
}

// Total Revenue This Month
$sql = "SELECT COALESCE(SUM(amount), 0) as total FROM receipts WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$result = mysqli_query($conn, $sql);
if ($result) {
    $stats['total_revenue'] = mysqli_fetch_assoc($result)['total'];
} else {
    echo "Error: " . mysqli_error($conn);
}

// Attendance Today
$sql = "SELECT COUNT(DISTINCT p_no) as total FROM attendance WHERE DATE(check_in) = CURDATE()";
$result = mysqli_query($conn, $sql);
if ($result) {
    $stats['attendance_today'] = mysqli_fetch_assoc($result)['total'];
} else {
    echo "Error: " . mysqli_error($conn);
}

// Expiring Memberships
$sql = "SELECT COUNT(*) as total FROM people WHERE role = 'member' AND membership_end BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
$result = mysqli_query($conn, $sql);
if ($result) {
    $stats['expiring_memberships'] = mysqli_fetch_assoc($result)['total'];
} else {
    echo "Error: " . mysqli_error($conn);
}

// Fetch data for charts
// Membership Distribution by Program
$program_distribution = [];
$sql = "SELECT 
    CASE 
        WHEN membership_type = 'strength' THEN 'Strength Training'
        WHEN membership_type = 'cardio' THEN 'Cardio Fitness'
        WHEN membership_type = 'weight_loss' THEN 'Weight Loss'
        WHEN membership_type = 'yoga' THEN 'Yoga'
        ELSE 'Other'
    END as program,
    COUNT(*) as count 
FROM people 
WHERE role = 'member' 
GROUP BY program";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $program_distribution[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Monthly Revenue
$monthly_revenue = [];
$sql = "SELECT 
    DATE_FORMAT(created_at, '%Y-%m') as month, 
    COALESCE(SUM(amount), 0) as total_revenue 
FROM receipts 
WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
GROUP BY month 
ORDER BY month";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $monthly_revenue[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Daily Attendance
$daily_attendance = [];
$sql = "SELECT 
    DATE(check_in) as date, 
    COUNT(DISTINCT p_no) as attendance_count 
FROM attendance 
WHERE check_in >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
GROUP BY date 
ORDER BY date";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $daily_attendance[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($conn);
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f9f9f9;
            color: #2c3e50;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ecf0f1;
        }

        .card-header, .card-body {
            background-color: #fff;
        }

        .btn-outline-secondary {
            color: #2c3e50;
            border-color: #ecf0f1;
        }

        .btn-outline-secondary:hover {
            background-color: #f1f1f1;
        }

        .text-primary {
            color: #3498db;
        }

        .text-info {
            color: #1abc9c;
        }

        .text-warning {
            color: #f39c12;
        }

        .text-success {
            color: #2ecc71;
        }

        .text-gray-800 {
            color: #34495e;
        }

        .chart-container {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .row {
            margin-bottom: 30px;
        }

        /* Smaller chart sizes */
        .chart-container canvas {
            max-height: 250px;
        }

        .col-md-4 {
            flex: 0 0 auto;
            width: 33.33%;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary">
                            <span data-feather="calendar"></span>
                            This week
                        </button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Members</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['total_members']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Members</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['active_members']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">New Members (This Month)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['new_members_this_month']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Revenue (This Month)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($stats['total_revenue'], 2); ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Membership Distribution</h6>
                            </div>
                            <div class="card-body chart-container">
                                <canvas id="membershipDistributionChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Monthly Revenue</h6>
                            </div>
                            <div class="card-body chart-container">
                                <canvas id="monthlyRevenueChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Daily Attendance</h6>
                            </div>
                            <div class="card-body chart-container">
                                <canvas id="dailyAttendanceChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Membership Distribution Chart
        const ctx1 = document.getElementById('membershipDistributionChart').getContext('2d');
        const membershipDistributionChart = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($program_distribution, 'program')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($program_distribution, 'count')); ?>,
                    backgroundColor: ['#3498db', '#2ecc71', '#f39c12', '#9b59b6', '#e74c3c'],
                    hoverOffset: 4
                }]
            }
        });

        // Monthly Revenue Chart
        const ctx2 = document.getElementById('monthlyRevenueChart').getContext('2d');
        const monthlyRevenueChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($monthly_revenue, 'month')); ?>,
                datasets: [{
                    label: 'Revenue ($)',
                    data: <?php echo json_encode(array_column($monthly_revenue, 'total_revenue')); ?>,
                    borderColor: '#1abc9c',
                    backgroundColor: 'rgba(26, 188, 156, 0.2)',
                    fill: true
                }]
            }
        });

        // Daily Attendance Chart
        const ctx3 = document.getElementById('dailyAttendanceChart').getContext('2d');
        const dailyAttendanceChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($daily_attendance, 'date')); ?>,
                datasets: [{
                    label: 'Attendance',
                    data: <?php echo json_encode(array_column($daily_attendance, 'attendance_count')); ?>,
                    backgroundColor: '#3498db',
                    borderColor: '#2980b9',
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
