<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // Retrieve all courses
        $sql = "SELECT course_id, course_name FROM courses";
        $result = $conn->query($sql);
        $courses = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }
        }

        echo json_encode($courses);
        break;

    case 'POST': // Add a new course
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['course_name'])) {
            $course_name = $conn->real_escape_string($data['course_name']);
            $sql = "INSERT INTO courses (course_name) VALUES ('$course_name')";

            if ($conn->query($sql)) {
                echo json_encode(["message" => "Course added successfully", "course_id" => $conn->insert_id]);
            } else {
                echo json_encode(["error" => "Failed to add course"]);
            }
        } else {
            echo json_encode(["error" => "Course name is required"]);
        }
        break;

    case 'PUT': // Update a course
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['course_id']) && !empty($data['course_name'])) {
            $course_id = (int) $data['course_id'];
            $course_name = $conn->real_escape_string($data['course_name']);
            $sql = "UPDATE courses SET course_name='$course_name' WHERE course_id=$course_id";

            if ($conn->query($sql)) {
                echo json_encode(["message" => "Course updated successfully"]);
            } else {
                echo json_encode(["error" => "Failed to update course"]);
            }
        } else {
            echo json_encode(["error" => "Course ID and name are required"]);
        }
        break;

    case 'DELETE': // Delete a course
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['course_id'])) {
            $course_id = (int) $data['course_id'];
            $sql = "DELETE FROM courses WHERE course_id=$course_id";

            if ($conn->query($sql)) {
                echo json_encode(["message" => "Course deleted successfully"]);
            } else {
                echo json_encode(["error" => "Failed to delete course"]);
            }
        } else {
            echo json_encode(["error" => "Course ID is required"]);
        }
        break;

    default:
        echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>