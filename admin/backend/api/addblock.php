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
    if (isset($_POST['block_name'])) {
        // Read from form data
        $block_name = $_POST['block_name'];
    } else {
        // Fallback to JSON approach
        $data = json_decode(file_get_contents('php://input'), true);
        $block_name = $data['block_name'] ?? null;
    }

    // Validate data
    if (!empty($block_name)) {
        // Check for duplicate block name
        $check_stmt = $conn->prepare("SELECT * FROM blocks WHERE block_name = :block_name");
        $check_stmt->bindParam(':block_name', $block_name);
        $check_stmt->execute();

        if ($check_stmt->rowCount() == 0) {
            // Insert query
            $stmt = $conn->prepare("INSERT INTO blocks (block_name) VALUES (:block_name)");
            $stmt->bindParam(':block_name', $block_name);

            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Block added successfully.',
                    'block_id' => $conn->lastInsertId()
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error adding block.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Block name already exists.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Please provide a block name.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Connection error: ' . $e->getMessage()]);
}
?>