<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database connection
$host = 'localhost';
$db_name = 'eclassrecord';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if we're receiving form data or JSON
    if (isset($_POST['course']) && isset($_POST['coursedetails'])) {
        // Read from form data (matches your frontend FormData approach)
        $course_name = $_POST['course'];
        $course_details = $_POST['coursedetails'];
    } else {
        // Fallback to JSON approach
        $data = json_decode(file_get_contents('php://input'), true);
        $course_name = $data['course_name'] ?? null;
        $course_details = $data['course_details'] ?? null;
    }

    // Validate data
    if (!empty($course_name) && !empty($course_details)) {
        // Check for duplicate course name
        $check_stmt = $conn->prepare("SELECT * FROM courses WHERE course_name = :course_name");
        $check_stmt->bindParam(':course_name', $course_name);
        $check_stmt->execute();

        if ($check_stmt->rowCount() == 0) {
            // Insert query
            $stmt = $conn->prepare("INSERT INTO courses (course_name, course_details) VALUES (:course_name, :course_details)");
            $stmt->bindParam(':course_name', $course_name);
            $stmt->bindParam(':course_details', $course_details);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Course added successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error adding course.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Course name already exists.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Please provide all required fields.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Connection error: ' . $e->getMessage()]);
}
?>