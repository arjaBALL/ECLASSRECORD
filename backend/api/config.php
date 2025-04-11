<?php
$host = "localhost";  // Change to your database host if needed
$username = "root";   // Change if you have a different MySQL username
$password = "";       // Change if your MySQL has a password
$dbname = "eclassrecord"; // Database name

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to UTF-8
$conn->set_charset("utf8");

// Uncomment this for debugging
// echo "Connected successfully";

?>