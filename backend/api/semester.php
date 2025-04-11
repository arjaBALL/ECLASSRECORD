<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // Retrieve all semester
        $sql = "SELECT semester_id, semester_name FROM semesters";
        $result = $conn->query($sql);
        $semester = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $semester[] = $row;
            }
        }

        echo json_encode($semester);
        break;

    case 'POST': // Add a new semester
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['semester_name'])) {
            $semester_name = $conn->real_escape_string($data['semester_name']);
            $sql = "INSERT INTO semesters (semester_name) VALUES ('$semester_name')";

            if ($conn->query($sql)) {
                echo json_encode(["message" => "Semester added successfully", "semester_id" => $conn->insert_id]);
            } else {
                echo json_encode(["error" => "Failed to add semester"]);
            }
        } else {
            echo json_encode(["error" => "Semestername is required"]);
        }
        break;

    case 'PUT': // Update a semester
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['semester_id']) && !empty($data['semester_name'])) {
            $semester_id = (int) $data['semester_id'];
            $semester_name = $conn->real_escape_string($data['semester_name']);
            $sql = "UPDATE semesters SET semester_name='$semester_name' WHERE semester_id=$semester_id";

            if ($conn->query($sql)) {
                echo json_encode(["message" => "Semester updated successfully"]);
            } else {
                echo json_encode(["error" => "Failed to update semester"]);
            }
        } else {
            echo json_encode(["error" => "Semester ID and name are required"]);
        }
        break;

    case 'DELETE': // Delete a semester
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['semesterid'])) {
            $semester_id = (int) $data['semester_id'];
            $sql = "DELETE FROM semesters WHERE semester_id=$semester_id";

            if ($conn->query($sql)) {
                echo json_encode(["message" => "semester deleted successfully"]);
            } else {
                echo json_encode(["error" => "Failed to delete semester"]);
            }
        } else {
            echo json_encode(["error" => "Semester ID is required"]);
        }
        break;

    default:
        echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>