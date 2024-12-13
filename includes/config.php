<?php
// Load configuration from ini file
$config = parse_ini_file(__DIR__ . "/../config.ini");

if ($config === false) {
    die("Error loading configuration file");
}

// Database credentials
define('DB_SERVER', $config['DB_HOST']);
define('DB_USERNAME', $config['DB_USER']);
define('DB_PASSWORD', $config['DB_PASS']);
define('DB_NAME', $config['DB_NAME']);

// Attempt to connect to MySQL database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Set charset to utf8mb4
if (!mysqli_set_charset($conn, "utf8mb4")) {
    die("Error setting charset to utf8mb4: " . mysqli_error($conn));
}

// Set timezone
date_default_timezone_set('Africa/Mogadishu');

return $conn;
