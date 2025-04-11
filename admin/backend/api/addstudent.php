<?php
// Database connection parameters
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "eclassrecord";

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set response header to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // For development - adjust for production
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Function to validate and sanitize input
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize student data from the form
    $studentid = isset($_POST['studentid']) ? sanitizeInput($_POST['studentid']) : '';
    $lastname = isset($_POST['lastname']) ? sanitizeInput($_POST['lastname']) : '';
    $firstname = isset($_POST['firstname']) ? sanitizeInput($_POST['firstname']) : '';
    $middlename = isset($_POST['middlename']) ? sanitizeInput($_POST['middlename']) : '';
    $year_id = isset($_POST['year_name']) ? (int) $_POST['year_name'] : 0;
    $semester_id = isset($_POST['semester_name']) ? (int) $_POST['semester_name'] : 0;

    // Validate required fields
    $errors = [];

    if (empty($studentid)) {
        $errors[] = "Student ID is required";
    }

    if (empty($lastname)) {
        $errors[] = "Last name is required";
    }

    if (empty($firstname)) {
        $errors[] = "First name is required";
    }

    if (empty($middlename)) {
        $errors[] = "Middle name is required";
    }

    if (empty($year_id)) {
        $errors[] = "Year level is required";
    }

    if (empty($semester_id)) {
        $errors[] = "Semester is required";
    }

    // If there are errors, return them
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'error' => implode(', ', $errors)
        ]);
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Check if student ID already exists
        $checkStmt = $conn->prepare("SELECT studentid FROM students WHERE studentid = ?");
        $checkStmt->bind_param("s", $studentid);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            throw new Exception("Student ID already exists");
        }
        $checkStmt->close();

        // Insert into students table
        $stmt = $conn->prepare("INSERT INTO students (studentid, lastname, firstname, middlename) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $studentid, $lastname, $firstname, $middlename);

        if (!$stmt->execute()) {
            throw new Exception("Error inserting student data: " . $stmt->error);
        }

        // Get the auto-generated student_id (integer primary key)
        $new_student_id = $conn->insert_id;
        $stmt->close();

        // Insert into student_enrollment table using the auto-generated student_id
        $enrollStmt = $conn->prepare("INSERT INTO student_enrollment 
            (student_id, year_id, semester_id) 
            VALUES (?, ?, ?)");

        $enrollStmt->bind_param("iii", $new_student_id, $year_id, $semester_id);

        if (!$enrollStmt->execute()) {
            throw new Exception("Error inserting enrollment data: " . $enrollStmt->error);
        }

        $enrollStmt->close();

        // Commit transaction
        $conn->commit();

        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Student added successfully'
        ]);

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();

        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }

} else {
    // If not a POST request
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request method. Only POST requests are accepted.'
    ]);
}

// Close the connection
$conn->close();
?>