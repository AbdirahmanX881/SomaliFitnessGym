<?php
// Load configuration
$config = parse_ini_file("../config.ini");

// Create connection without database
$conn = new mysqli($config['host'], $config['username'], $config['password']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read and execute SQL file
$sql = file_get_contents('schema.sql');

if ($conn->multi_query($sql)) {
    do {
        // Store first result set
        if ($result = $conn->store_result()) {
            $result->free();
        }
        // Move to next result set
    } while ($conn->more_results() && $conn->next_result());
    
    echo "Database setup completed successfully!\n";
} else {
    echo "Error executing SQL: " . $conn->error . "\n";
}

$conn->close();
