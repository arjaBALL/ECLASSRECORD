<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Only POST method is allowed']);
    exit();
}

// TODO: Add admin authentication check here
// For example, validate an admin token from Authorization header

// Get JSON data from request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Check if data is valid JSON
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit();
}

// Check if all required fields are present
if (!isset($data['teacher_id']) || empty($data['teacher_id'])) {
    echo json_encode(['success' => false, 'message' => 'Teacher ID is required']);
    exit();
}

if (!isset($data['approval_status']) || !in_array($data['approval_status'], ['approved', 'rejected'])) {
    echo json_encode(['success' => false, 'message' => 'Valid approval status (approved/rejected) is required']);
    exit();
}

// Database configuration
$db_host = 'localhost';
$db_name = 'eclassrecord_db';
$db_user = 'root';
$db_password = '';

try {
    // Connect to database
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if teacher exists
    $check_query = "SELECT COUNT(*) FROM teachers WHERE teacher_id = :teacher_id";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bindParam(':teacher_id', $data['teacher_id']);
    $check_stmt->execute();

    if ($check_stmt->fetchColumn() == 0) {
        echo json_encode(['success' => false, 'message' => 'Teacher not found']);
        exit();
    }

    // Update teacher approval status
    $account_status = ($data['approval_status'] == 'approved') ? 'active' : 'inactive';
    $update_query = "UPDATE teachers 
                     SET approval_status = :approval_status, account_status = :account_status, updated_at = NOW() 
                     WHERE teacher_id = :teacher_id";

    $stmt = $conn->prepare($update_query);
    $stmt->bindParam(':approval_status', $data['approval_status']);
    $stmt->bindParam(':account_status', $account_status);
    $stmt->bindParam(':teacher_id', $data['teacher_id']);

    $stmt->execute();

    // Prepare status message
    $status_message = ($data['approval_status'] == 'approved')
        ? 'Teacher account approved and activated successfully'
        : 'Teacher registration rejected';

    echo json_encode(['success' => true, 'message' => $status_message]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>