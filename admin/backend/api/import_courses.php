<?php
// import_courses.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode("Method not allowed");
    exit();
}

if (!isset($_FILES['excel_file'])) {
    http_response_code(400);
    echo json_encode("No file uploaded");
    exit();
}

require 'vendor/autoload.php'; // Load PhpSpreadsheet via Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

$inputFile = $_FILES['excel_file']['tmp_name'];

try {
    $spreadsheet = IOFactory::load($inputFile);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    $conn = new mysqli("localhost", "root", "", "eclassrecord_db");
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Skip the header row
    for ($i = 1; $i < count($rows); $i++) {
        $course_id = $conn->real_escape_string(trim($rows[$i][0]));
        $name = $conn->real_escape_string(trim($rows[$i][1]));
        $details = $conn->real_escape_string(trim($rows[$i][2]));

        if (!$course_id || !$name || !$details)
            continue;

        $sql = "INSERT INTO courses (course_id, name, course_details) 
                VALUES ('$course_id', '$name', '$details') 
                ON DUPLICATE KEY UPDATE name='$name', course_details='$details'";

        if (!$conn->query($sql)) {
            throw new Exception("Insert failed: " . $conn->error);
        }
    }

    $conn->close();
    echo json_encode("Courses imported successfully.");

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Error: " . $e->getMessage());
    exit();
}
?>