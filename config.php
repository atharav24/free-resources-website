<?php
// config.php

$host = 'localhost';      // Your database host (usually localhost)
$dbname = 'myweb_db';     // Your database name
$user = 'root';           // Your database username
$pass = 'mysql2002';      // Your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set charset to utf8mb4 for better encoding support
$conn->set_charset("utf8mb4");
?>
