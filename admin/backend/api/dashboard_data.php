<?php
// get_stats.php
$host = "localhost";
$dbname = "eclassrecord_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Total Teachers
    $stmt = $pdo->query("SELECT COUNT(*) AS total_teachers FROM teachers");
    $total_teachers = $stmt->fetch()['total_teachers'];

    // Total Students
    $stmt = $pdo->query("SELECT COUNT(*) AS total_students FROM student");
    $total_students = $stmt->fetch()['total_students'];

    // Active Teachers
    $stmt = $pdo->query("SELECT COUNT(*) AS active_teachers FROM teachers WHERE account_status = 'active'");
    $active_teachers = $stmt->fetch()['active_teachers'];

    // Pending Requests
    $stmt = $pdo->query("SELECT COUNT(*) AS pending_requests FROM teachers WHERE approval_status = 'pending'");
    $pending_requests = $stmt->fetch()['pending_requests'];

    echo json_encode([
        'total_teachers' => $total_teachers,
        'total_students' => $total_students,
        'active_teachers' => $active_teachers,
        'pending_requests' => $pending_requests
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
?>