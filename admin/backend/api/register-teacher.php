<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
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

// Get JSON data from request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Check if data is valid JSON
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit();
}

// Check if all required fields are present
$required_fields = ['teacher_id', 'lastname', 'firstname', 'email', 'password'];
foreach ($required_fields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        echo json_encode(['success' => false, 'message' => $field . ' is required']);
        exit();
    }
}

// Validate email format
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit();
}

// Database configuration
$db_host = 'localhost';
$db_name = 'eclassrecord';
$db_user = 'root';
$db_password = '';

try {
    // Connect to database
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if teacher ID already exists
    $check_query = "SELECT COUNT(*) FROM teachers WHERE teacher_id = :teacher_id";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bindParam(':teacher_id', $data['teacher_id']);
    $check_stmt->execute();

    if ($check_stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Teacher ID already exists']);
        exit();
    }

    // Check if email already exists
    $check_email_query = "SELECT COUNT(*) FROM teachers WHERE email = :email";
    $check_email_stmt = $conn->prepare($check_email_query);
    $check_email_stmt->bindParam(':email', $data['email']);
    $check_email_stmt->execute();

    if ($check_email_stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already in use']);
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

    // Insert new teacher with pending approval status
    $insert_query = "INSERT INTO teachers (teacher_id, lastname, firstname, email, password, approval_status, account_status, created_at) 
                    VALUES (:teacher_id, :lastname, :firstname, :email, :password, 'pending', 'inactive', NOW())";

    $stmt = $conn->prepare($insert_query);
    $stmt->bindParam(':teacher_id', $data['teacher_id']);
    $stmt->bindParam(':lastname', $data['lastname']);
    $stmt->bindParam(':firstname', $data['firstname']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':password', $hashed_password);

    $stmt->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Teacher registration submitted successfully. Your account will be active once approved by an administrator.'
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>