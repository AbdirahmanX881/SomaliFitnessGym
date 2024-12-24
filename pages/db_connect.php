<?php
$servername = "localhost"; // Or your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "SomaliFitnessGym"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
