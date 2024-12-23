<div class="sidebar col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'members.php' ? 'active' : ''; ?>" href="members.php">
                    <i class="fas fa-users me-2"></i>
                    Members
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'payments.php' ? 'active' : ''; ?>" href="payments.php">
                    <i class="fas fa-dollar-sign me-2"></i>
                    Payments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'measurements.php' ? 'active' : ''; ?>" href="measurements.php">
                    <i class="fas fa-weight me-2"></i>
                    Measurements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'attendance.php' ? 'active' : ''; ?>" href="attendance.php">
                    <i class="fas fa-calendar-check me-2"></i>
                    Attendance
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>" href="reports.php">
                    <i class="fas fa-chart-bar me-2"></i>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'courses.php' ? 'active' : ''; ?>" href="courses.php">
                    <i class="fas fa-dumbbell me-2"></i>
                    Programs
                </a>
            </li>
        </ul>

        <hr class="my-3">

        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>" href="settings.php">
                    <i class="fas fa-cog me-2"></i>
                    Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>
