<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // Retrieve all year
        $sql = "SELECT year_id, year_name FROM year_levels";
        $result = $conn->query($sql);
        $year = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $year[] = $row;
            }
        }

        echo json_encode($year);
        break;

    case 'POST': // Add a new year
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['year_name'])) {
            $year_name = $conn->real_escape_string($data['year_name']);
            $sql = "INSERT INTO year_levels (year_name) VALUES ('$year_name')";

            if ($conn->query($sql)) {
                echo json_encode(["message" => "Year added successfully", "Year_id" => $conn->insert_id]);
            } else {
                echo json_encode(["error" => "Failed to add Year"]);
            }
        } else {
            echo json_encode(["error" => "Year is required"]);
        }
        break;

    case 'PUT': // Update a year
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['year_id']) && !empty($data['year_name'])) {
            $year_id = (int) $data['year_id'];
            $year_name = $conn->real_escape_string($data['year_name']);
            $sql = "UPDATE year_levels SET year_name='$year_name' WHERE year_id=$year_id";

            if ($conn->query($sql)) {
                echo json_encode(["message" => "Year updated successfully"]);
            } else {
                echo json_encode(["error" => "Failed to update Year"]);
            }
        } else {
            echo json_encode(["error" => "Year ID and name are required"]);
        }
        break;

    case 'DELETE': // Delete a year
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['year_id'])) {
            $year_id = (int) $data['year_id'];
            $sql = "DELETE FROM year_levels WHERE year_id=$year_id";

            if ($conn->query($sql)) {
                echo json_encode(["message" => "Year deleted successfully"]);
            } else {
                echo json_encode(["error" => "Failed to delete year"]);
            }
        } else {
            echo json_encode(["error" => "Year ID is required"]);
        }
        break;

    default:
        echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>