<?php
// addschedule.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection configuration
$host = 'localhost';
$dbname = 'eclassrecord';
$username = 'root';
$password = '';

// Time slot mapping
$timeSlotMap = [
    1 => ['start_time' => '07:00:00', 'end_time' => '08:30:00'],
    2 => ['start_time' => '08:30:00', 'end_time' => '10:00:00'],
    3 => ['start_time' => '10:00:00', 'end_time' => '11:30:00'],
    4 => ['start_time' => '11:30:00', 'end_time' => '13:00:00'],
    5 => ['start_time' => '13:00:00', 'end_time' => '14:30:00'],
    6 => ['start_time' => '14:30:00', 'end_time' => '16:00:00'],
    7 => ['start_time' => '16:00:00', 'end_time' => '17:30:00'],
    8 => ['start_time' => '17:30:00', 'end_time' => '19:00:00'],
    9 => ['start_time' => '19:00:00', 'end_time' => '20:30:00']
];

// Response array
$response = [
    'success' => false,
    'message' => ''
];

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get JSON data from the request body
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validate required fields
    $requiredFields = [
        'selectedYear',
        'selectedSemester',
        'selectedCourse',
        'selectedBlock',
        'selectedSubject',
        'selectedtime',
        'selectedDays',
        'classcode'
    ];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            throw new Exception("Missing or empty field: $field");
        }
    }

    // Ensure arrays are properly formatted
    $selectedDays = is_array($data['selectedDays']) ? $data['selectedDays'] : explode(',', $data['selectedDays']);
    $selectedTimes = is_array($data['selectedtime']) ? $data['selectedtime'] : explode(',', $data['selectedtime']);

    // Create placeholders for days
    $dayPlaceholders = implode(',', array_fill(0, count($selectedDays), '?'));

    // Check for existing conflicting schedules
    $conflictCheck = $pdo->prepare("
        SELECT s.*, sub.subject_name, c.course_name, sem.semester_name, y.year_name 
        FROM schedules s
        JOIN subjects sub ON s.subject_id = sub.subject_id
        JOIN courses c ON s.course_id = c.course_id
        JOIN semesters sem ON s.semester_id = sem.semester_id
        JOIN year_levels y ON s.year_id = y.year_id
        WHERE s.year_id = ? 
        AND s.semester_id = ? 
        AND s.course_id = ? 
        AND s.block_id = ? 
        AND s.subject_id = ? 
        AND s.day IN ($dayPlaceholders)
    ");

    // Prepare parameters for conflict check
    $conflictParams = [
        $data['selectedYear'],
        $data['selectedSemester'],
        $data['selectedCourse'],
        $data['selectedBlock'],
        $data['selectedSubject']
    ];

    // Add days to the parameters
    $conflictParams = array_merge($conflictParams, $selectedDays);

    $conflictCheck->execute($conflictParams);
    $existingSchedules = $conflictCheck->fetchAll(PDO::FETCH_ASSOC);

    // If conflicting schedules exist, return detailed conflict information
    if (!empty($existingSchedules)) {
        $conflictDetails = [];
        foreach ($existingSchedules as $schedule) {
            $conflictDetails[] = [
                'subject' => $schedule['subject_name'],
                'course' => $schedule['course_name'],
                'semester' => $schedule['semester_name'],
                'year' => $schedule['year_name'],
                'day' => $schedule['day'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time']
            ];
        }

        $response['success'] = false;
        $response['message'] = 'Conflicting schedules found';
        $response['conflicts'] = $conflictDetails;
        echo json_encode($response);
        exit;
    }

    // Check for duplicate class code
    $duplicateCodeCheck = $pdo->prepare("
        SELECT * FROM schedules 
        WHERE class_code = ?
    ");
    $duplicateCodeCheck->execute([$data['classcode']]);
    $existingClassCode = $duplicateCodeCheck->fetch(PDO::FETCH_ASSOC);

    if ($existingClassCode) {
        $response['success'] = false;
        $response['message'] = 'Class code already exists';
        echo json_encode($response);
        exit;
    }

    // Prepare SQL statement for inserting schedule
    $stmt = $pdo->prepare("
        INSERT INTO schedules 
        (class_code, subject_id, block_id, year_id, semester_id, course_id, day, start_time, end_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // Insert schedules for each selected day and time
    $insertedSchedules = [];
    foreach ($selectedDays as $day) {
        foreach ($selectedTimes as $timeSlotId) {
            // Get start and end times from the time slot map
            $timeSlot = $timeSlotMap[$timeSlotId] ?? null;

            if (!$timeSlot) {
                throw new Exception("Invalid time slot ID: $timeSlotId");
            }

            $stmt->execute([
                $data['classcode'],
                $data['selectedSubject'],
                $data['selectedBlock'],
                $data['selectedYear'],
                $data['selectedSemester'],
                $data['selectedCourse'],
                $day,
                $timeSlot['start_time'],
                $timeSlot['end_time']
            ]);

            $insertedSchedules[] = [
                'day' => $day,
                'start_time' => $timeSlot['start_time'],
                'end_time' => $timeSlot['end_time']
            ];
        }
    }

    $response['success'] = true;
    $response['message'] = 'Schedule added successfully';
    $response['inserted_schedules'] = $insertedSchedules;

} catch (PDOException $e) {
    $response['message'] = "Database error: " . $e->getMessage();
    error_log("PDO Error: " . $e->getMessage());
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    error_log("General Error: " . $e->getMessage());
}

// Send JSON response
echo json_encode($response);
?>