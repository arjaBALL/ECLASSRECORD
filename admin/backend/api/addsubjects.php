<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Database connection params
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eclassrecord";

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Initialize response array
$response = array(
    "success" => false,
    "message" => ""
);

// Check required fields
if (
    empty($data->subject_code) ||
    empty($data->subject_name) ||
    empty($data->year_id) ||
    empty($data->course_id) ||
    empty($data->semester_id)
) {
    $response["message"] = "Missing required fields.";
    echo json_encode($response);
    exit();
}

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Check for duplicates
    $check = $conn->prepare("SELECT subject_id FROM subjects WHERE subject_code = ? OR subject_name = ?");
    $check->bind_param("ss", $data->subject_code, $data->subject_name);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        throw new Exception("Subject with same code or name already exists.");
    }
    $check->close();

    // Insert new subject - using the correct column names from schema
    $stmt = $conn->prepare("INSERT INTO subjects (subject_code, subject_name, year_id, course_id, semester_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $data->subject_code, $data->subject_name, $data->year_id, $data->course_id, $data->semester_id);

    if ($stmt->execute()) {
        $response["success"] = true;
        $response["message"] = "Subject added successfully.";
        $response["subject_id"] = $conn->insert_id;
    } else {
        throw new Exception("Failed to add subject: " . $stmt->error);
    }

    // Close resources
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

// Return response
echo json_encode($response);
?>