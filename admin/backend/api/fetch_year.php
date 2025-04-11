<?php
// Enable CORS to allow requests from frontend (Vue or any other)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "eclassrecord";

$conn = new mysqli($host, $user, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Correct SQL query to fetch department data
$sql = "SELECT year_id, year_name FROM year_levels";  // Check table & column names
$result = $conn->query($sql);

$yearlevel = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $yearlevel[] = $row;
    }
}

// Return department data as JSON
echo json_encode($yearlevel);
$conn->close();
?>