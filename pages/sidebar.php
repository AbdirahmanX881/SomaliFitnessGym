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
            <li class="nav-item">
                <button class="toggle-dark-mode btn btn-light" onclick="toggleDarkMode()">
                    <i class="fas fa-moon"></i> Toggle Dark Mode
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- JavaScript -->
<script>
    // Check if dark mode is already saved in localStorage
    if (localStorage.getItem('dark-mode') === 'enabled') {
        document.body.classList.add('dark-mode');
        document.querySelector('.sidebar').classList.add('dark-mode');
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.add('dark-mode');
        });
    }

    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        document.querySelector('.sidebar').classList.toggle('dark-mode');
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.toggle('dark-mode');
        });

        // Save preference in localStorage
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            localStorage.setItem('dark-mode', 'disabled');
        }

        // Toggle dark mode button style
        const button = document.querySelector('.toggle-dark-mode');
        button.classList.toggle('dark-mode');
    }
</script>

<!-- CSS for Light and Dark Mode -->
<style>
    /* Light Mode (default) */
    body {
        background-color: #f8f9fa;
        color: #212529;
    }

    .sidebar {
        background-color:rgb(153, 172, 192);
        color: #212529;
    }

    .nav-link {
        color:rgb(3, 27, 51);
    }

    .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
    }

    /* Dark Mode */
    body.dark-mode {
        background-color:rgba(18, 18, 19, 0.18);
        color:rgb(3, 3, 49);
    }

    .sidebar.dark-mode {
        background-color: #212529;
        color:rgb(1, 10, 20);
    }

    .nav-link.dark-mode {
        color:rgb(1, 10, 20);
    }

    .nav-link.active.dark-mode {
        background-color: #0d6efd;
        color: #f8f9fa;
    }

    /* Button to toggle dark mode */
    .toggle-dark-mode {
        background-color: transparent;
        border: none;
        color:rgb(2, 18, 33);
        cursor: pointer;
    }

    .toggle-dark-mode.dark-mode {
        color:rgb(3, 18, 33);
    }
</style>
