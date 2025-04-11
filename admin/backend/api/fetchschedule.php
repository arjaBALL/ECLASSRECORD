<?php
// Enable CORS to allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Database connection configuration
$host = 'localhost';
$dbname = 'eclassrecord';
$username = 'your_username'; // Replace with your database username
$password = 'your_password'; // Replace with your database password

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare a comprehensive SQL query to fetch schedule data
    $query = "
    SELECT 
        s.schedule_id, 
        s.class_code, 
        sub.subject_code, 
        sub.subject_name, 
        b.block_name, 
        yl.year_name, 
        sem.semester_name, 
        c.course_name, 
        CASE s.day 
            WHEN '1' THEN 'Monday'
            WHEN '2' THEN 'Tuesday'
            WHEN '3' THEN 'Wednesday'
            WHEN '4' THEN 'Thursday'
            WHEN '5' THEN 'Friday'
            WHEN '6' THEN 'Saturday'
            WHEN '7' THEN 'Sunday'
        END AS day_name,
        s.start_time, 
        s.end_time, 
        s.room
    FROM 
        schedules s
    LEFT JOIN subjects sub ON s.subject_id = sub.subject_id
    LEFT JOIN blocks b ON s.block_id = b.block_id
    LEFT JOIN year_levels yl ON s.year_id = yl.year_id
    LEFT JOIN semesters sem ON s.semester_id = sem.semester_id
    LEFT JOIN courses c ON s.course_id = c.course_id
    ORDER BY 
        s.schedule_id
    ";

    // Execute the query
    $stmt = $pdo->query($query);

    // Fetch all results
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    echo json_encode([
        'status' => 'success',
        'data' => $schedules
    ]);

} catch (PDOException $e) {
    // Handle any database connection or query errors
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>