<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Content-Type: application/json");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Only GET method is allowed']);
    exit();
}

// TODO: Add admin authentication check here
// For example, validate an admin token from Authorization header

// Database configuration
$db_host = 'localhost';
$db_name = 'eclassrecord_db';
$db_user = 'root';
$db_password = '';

try {
    // Connect to database
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get approval status filter from query parameter (default to 'pending')
    $approval_status = isset($_GET['status']) ? $_GET['status'] : 'pending';

    // Validate status parameter
    if (!in_array($approval_status, ['pending', 'approved', 'rejected', 'all'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid status parameter']);
        exit();
    }

    // Build query based on status filter
    if ($approval_status == 'all') {
        $query = "SELECT id, teacher_id, lastname, firstname, email, approval_status, account_status, created_at 
                 FROM teachers ORDER BY created_at DESC";
        $stmt = $conn->prepare($query);
    } else {
        $query = "SELECT id, teacher_id, lastname, firstname, email, approval_status, account_status, created_at 
                 FROM teachers WHERE approval_status = :approval_status ORDER BY created_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':approval_status', $approval_status);
    }

    $stmt->execute();
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $teachers]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>