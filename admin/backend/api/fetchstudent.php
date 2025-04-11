<?php
// Enable CORS to allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$dbname = "eclassrecord_db"; // Updated database name to match SQL dump

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "error" => "Connection failed: " . $conn->connect_error
    ]));
}

// Prepare SQL query to fetch student data with joined tables for related info
// Prepare SQL query with explicit aliases for name columns
$sql = "SELECT s.student_id, s.student_school_id, s.first_name, s.last_name, s.email,
                c.name AS course_name, c.course_id,
                y.name AS year_level_name, y.year_level_id,
                sec.name AS section_name, sec.section_id
         FROM student s
         JOIN courses c ON s.course_id = c.course_id
         JOIN year_levels y ON s.year_level_id = y.year_level_id
         JOIN sections sec ON s.section_id = sec.section_id";

// Initialize where clause array
$where = [];
$params = [];
$types = "";

// Search parameter
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";
    $where[] = "(s.last_name LIKE ? OR s.first_name LIKE ? OR s.student_id LIKE ?)";
    $params[] = $search;
    $params[] = $search;
    $params[] = $search;
    $types .= "sss";
}

// Course filter
if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    $where[] = "s.course_id = ?";
    $params[] = $_GET['course_id'];
    $types .= "i";
}

// Year level filter
if (isset($_GET['year_level_id']) && !empty($_GET['year_level_id'])) {
    $where[] = "s.year_level_id = ?";
    $params[] = $_GET['year_level_id'];
    $types .= "i";
}

// Section filter
if (isset($_GET['section_id']) && !empty($_GET['section_id'])) {
    $where[] = "s.section_id = ?";
    $params[] = $_GET['section_id'];
    $types .= "i";
}

// Add WHERE clause if there are conditions
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// Sorting
$allowedSortFields = ['student_school_id', 'first_name', 'last_name', 'course_id', 'year_level_id', 'section_id'];
$sortField = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $allowedSortFields) ? $_GET['sort_by'] : 'last_name';
$sortDirection = isset($_GET['sort_dir']) && strtoupper($_GET['sort_dir']) === 'DESC' ? 'DESC' : 'ASC';
$sql .= " ORDER BY s.$sortField $sortDirection";

// Prepare and execute statement
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$students = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = [
            'student_id' => $row['student_id'],
            'student_school_id' => $row['student_school_id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'course' => $row['course_name'],
            'course_id' => $row['course_id'],
            'year_level' => $row['year_level_name'],
            'year_level_id' => $row['year_level_id'],
            'section' => $row['section_name'],
            'section_id' => $row['section_id']
        ];
    }
}

// Return student data as JSON
echo json_encode([
    'success' => true,
    'data' => $students
]);

$stmt->close();
$conn->close();
?>