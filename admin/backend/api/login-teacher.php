<?php
// Enable CORS and set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Start the session
session_start();

// Include DB connection
$host = 'localhost';
$db = 'eclassrecord_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $e->getMessage()
    ]));
}

// Parse JSON input
$data = json_decode(file_get_contents("php://input"));

$response = [
    "success" => false,
    "message" => "",
    "teacher" => null
];

// Validation
if (empty($data->teacher_id) || empty($data->password)) {
    $response['message'] = "Teacher ID and password are required.";
    echo json_encode($response);
    exit;
}

// Clean inputs
$teacher_id = htmlspecialchars(strip_tags($data->teacher_id));
$password = htmlspecialchars(strip_tags($data->password));

try {
    // Check if teacher exists and get their data
    $stmt = $pdo->prepare("SELECT id, teacher_id, firstname, lastname, email, password,
                           approval_status, account_status, role
                          FROM teachers
                           WHERE teacher_id = :teacher_id");
    $stmt->bindParam(":teacher_id", $teacher_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if (password_verify($password, $teacher['password'])) {
            // Check account status
            if ($teacher['approval_status'] != 'approved' || $teacher['account_status'] != 'active') {
                $response['message'] = "Your account is not active or awaiting approval. Please contact the administrator.";
            } else {
                // Login successful
                $response['success'] = true;
                $response['message'] = "Login successful.";

                // Add the teacher's role and teacher_id for redirection purposes
                $teacher['role'] = $teacher['role']; // e.g., 'teacher'
                unset($teacher['password']); // Remove sensitive data before sending to client

                // Create session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['teacher_id'] = $teacher['teacher_id'];
                $_SESSION['user_id'] = $teacher['id'];
                $_SESSION['role'] = $teacher['role'];
                $_SESSION['firstname'] = $teacher['firstname'];
                $_SESSION['lastname'] = $teacher['lastname'];
                $_SESSION['email'] = $teacher['email'];

                // Set session cookie parameters for better security (optional)
                session_regenerate_id(true); // Regenerate session ID to prevent session fixation

                $response['teacher'] = $teacher;
                $response['session_id'] = session_id(); // Optionally send session ID (usually not needed)
            }
        } else {
            $response['message'] = "Invalid password.";
        }
    } else {
        $response['message'] = "Teacher ID not found.";
    }
} catch (PDOException $e) {
    $response['message'] = "Database error: " . $e->getMessage();
}

echo json_encode($response);
?>