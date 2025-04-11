<?php
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

// Connect to database
$conn = new mysqli("localhost", "root", "", "eclassrecord");

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get parameters from request
$year_id = isset($_GET['year_id']) ? $_GET['year_id'] : null;
$semester_id = isset($_GET['semester_id']) ? $_GET['semester_id'] : null;
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;

// Build the query with multiple conditions
$sql = "SELECT * FROM subjects WHERE 1=1";

if ($year_id) {
    $sql .= " AND year_id = " . $conn->real_escape_string($year_id);
}

if ($semester_id) {
    $sql .= " AND semester_id = " . $conn->real_escape_string($semester_id);
}

if ($course_id) {
    $sql .= " AND course_id = " . $conn->real_escape_string($course_id);
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
    echo json_encode($subjects);
} else {
    echo json_encode([]);
}

$conn->close();
?>