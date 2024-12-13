<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/SomaliFitnessGym">Somali Fitness</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'about.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym/pages/about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'courses.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym/pages/courses.php">Courses</a>
                </li>
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym/pages/dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'members.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym/pages/members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'measurements.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym/pages/measurements.php">Measurements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'payments.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym/pages/payments.php">Payments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'attendance.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym/pages/attendance.php">Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'reports.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym/pages/reports.php">Reports</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/SomaliFitnessGym/pages/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'login.php' ? 'active' : ''; ?>" href="/SomaliFitnessGym/pages/login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
