<?php
// Database configuration
$host = 'localhost';      // Database host
$dbname = '062_hotel';     // Database name
$username = 'root';       // Database username
$password = '';           // Database password

// Create mysqli connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
    die();
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");

// echo "Connected successfully";
?>
