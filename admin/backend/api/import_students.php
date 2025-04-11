<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$host = 'localhost';
$db = 'eclassrecord_db';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if (isset($_FILES['excel_file']['tmp_name'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    for ($i = 1; $i < count($rows); $i++) {
        $student_id = $conn->real_escape_string($rows[$i][0]);
        $first_name = $conn->real_escape_string($rows[$i][1]);
        $last_name = $conn->real_escape_string($rows[$i][2]);
        $email = $conn->real_escape_string($rows[$i][3]);
        $course_name = $conn->real_escape_string($rows[$i][4]);
        $year_level = $conn->real_escape_string($rows[$i][5]);
        $section_name = $conn->real_escape_string($rows[$i][6]);

        // Check if the student already exists
        $student_check = $conn->prepare("SELECT 1 FROM student WHERE student_id = ?");
        $student_check->bind_param("s", $student_id);
        $student_check->execute();
        $student_check->store_result();

        // If the student exists, skip the insertion
        if ($student_check->num_rows > 0) {
            $student_check->close();
            continue; // Skip to the next student
        }

        $student_check->close();

        // Normalize course
        $course_id = getOrInsert($conn, 'courses', $course_name, 'course_id');

        // Normalize year level
        $year_level_id = getOrInsert($conn, 'year_levels', $year_level, 'year_level_id');

        // Normalize section
        $section_id = getOrInsert($conn, 'sections', $section_name, 'section_id');

        // Insert student
        $insert_stmt = $conn->prepare("INSERT INTO student (student_id, first_name, last_name, email, course_id, year_level_id, section_id)
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("ssssiii", $student_id, $first_name, $last_name, $email, $course_id, $year_level_id, $section_id);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    echo "Data imported successfully with full normalization!";
} else {
    echo "Please upload an Excel file.";
}

$conn->close();

// Updated function for normalization with dynamic id column name
function getOrInsert($conn, $table, $name, $id_column)
{
    // Initialize variable to avoid unassigned variable error
    $result_id = null;

    // Check if the name exists in the table - using the correct ID column name
    $stmt = $conn->prepare("SELECT $id_column FROM $table WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    $stmt->bind_result($result_id);
    if ($stmt->fetch()) {
        $stmt->close();
        return $result_id; // Return existing id if found
    }
    $stmt->close();

    // Insert new value if not found
    $stmt = $conn->prepare("INSERT INTO $table (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $new_id = $stmt->insert_id;
    $stmt->close();
    return $new_id; // Return newly inserted id
}
?>