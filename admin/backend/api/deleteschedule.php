<?php
// Enable CORS to allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$dbname = "eclassrecord";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "error" => "Connection failed: " . $conn->connect_error
    ]));
}

// Get schedule ID from the request
if (isset($_GET['schedule_id'])) {
    $schedule_id = intval($_GET['schedule_id']);

    // Prepare SQL query to delete the schedule
    $stmt = $conn->prepare("DELETE FROM schedules WHERE schedule_id = ?");
    $stmt->bind_param("i", $schedule_id);

    // Execute the delete query
    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Schedule deleted successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "error" => "Error deleting schedule: " . $conn->error
        ]);
    }

    $stmt->close();
} else {
    // List schedules if no ID provided for deletion
    // Prepare SQL query to fetch schedule data with optional search and sorting
    $sql = "SELECT s.*, b.block_name, sub.subject_name 
            FROM schedules s
            JOIN blocks b ON s.block_id = b.block_id
            JOIN subjects sub ON s.subject_id = sub.subject_id";

    // Optional search parameter
    if (isset($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);
        $sql .= " WHERE s.class_code LIKE '%$search%' OR b.block_name LIKE '%$search%' OR sub.subject_name LIKE '%$search%' OR s.day LIKE '%$search%' OR s.room LIKE '%$search%'";
    }

    // Optional sorting parameter
    $sortBy = isset($_GET['sort']) ? $conn->real_escape_string($_GET['sort']) : 'schedule_id';
    $sql .= " ORDER BY $sortBy";

    // Execute query
    $result = $conn->query($sql);

    $schedules = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $schedules[] = $row;
        }
    }

    // Return schedule data as JSON
    echo json_encode($schedules);
}

$conn->close();
?>