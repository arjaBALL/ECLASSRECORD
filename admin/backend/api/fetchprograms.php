<?php
// Required headers for API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "eclassrecord_db"; // Updated database name to match SQL dump

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "error" => "Connection failed: " . $conn->connect_error
    ]));
}


try {
    // Initialize response array
    $response = array(
        "success" => false,
        "data" => array(),
        "message" => ""
    );

    // Build the base query with JOINs to get courses with year levels and sections
    $baseQuery = "
        SELECT 
            c.course_id,
            c.name AS course_name,
            c.course_details,
            y.year_level_id,
            y.name AS year_level_name,
            s.section_id,
            s.name AS section_name
        FROM 
            courses c
        LEFT JOIN 
            year_levels y ON c.course_id = y.course_id
        LEFT JOIN 
            sections s ON c.course_id = s.course_id
    ";

    // Initialize where conditions and parameters
    $whereConditions = array();
    $params = array();
    $types = "";

    // Apply search filter if provided
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = '%' . $_GET['search'] . '%';
        $whereConditions[] = "(c.name LIKE ? OR c.course_details LIKE ? OR y.name LIKE ? OR s.name LIKE ?)";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= "ssss";
    }

    // Apply year level filter if provided
    if (isset($_GET['year_level_id']) && !empty($_GET['year_level_id'])) {
        $whereConditions[] = "y.year_level_id = ?";
        $params[] = $_GET['year_level_id'];
        $types .= "i";
    }

    // Apply course filter if provided
    if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
        $whereConditions[] = "c.course_id = ?";
        $params[] = $_GET['course_id'];
        $types .= "i";
    }

    // Apply section filter if provided
    if (isset($_GET['section_id']) && !empty($_GET['section_id'])) {
        $whereConditions[] = "s.section_id = ?";
        $params[] = $_GET['section_id'];
        $types .= "i";
    }

    // Combine WHERE conditions if any
    if (!empty($whereConditions)) {
        $baseQuery .= " WHERE " . implode(" AND ", $whereConditions);
    }

    // Apply sorting if provided
    $sortField = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'c.name';
    $sortDir = isset($_GET['sort_dir']) && strtoupper($_GET['sort_dir']) === 'DESC' ? 'DESC' : 'ASC';

    // Validate sort field to prevent SQL injection
    $allowedSortFields = [
        'c.name' => 'c.name',
        'course_id' => 'c.course_id',
        'y.name' => 'y.name',
        'year_level_id' => 'y.year_level_id',
        's.name' => 's.name',
        'section_id' => 's.section_id'
    ];

    $sortField = array_key_exists($sortField, $allowedSortFields) ? $allowedSortFields[$sortField] : 'c.name';
    $baseQuery .= " ORDER BY $sortField $sortDir";

    // Prepare and execute the statement
    $stmt = $conn->prepare($baseQuery);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $courses = array();

        while ($row = $result->fetch_assoc()) {
            // Create course, year level, and section data
            $course = array(
                'course_id' => $row['course_id'],
                'course' => $row['course_name'],
                'course_details' => $row['course_details'],
                'year_level_id' => $row['year_level_id'],
                'year_level' => $row['year_level_name'],
                'section_id' => $row['section_id'],
                'section' => $row['section_name']
            );

            $courses[] = $course;
        }

        $response["success"] = true;
        $response["data"] = $courses;
        $response["message"] = "Courses data retrieved successfully";
    } else {
        $response["message"] = "No courses found";
    }

    // Close statement
    $stmt->close();

} catch (Exception $e) {
    $response["message"] = "Error: " . $e->getMessage();
}

// Close connection
$conn->close();

// Send response
echo json_encode($response);
?>