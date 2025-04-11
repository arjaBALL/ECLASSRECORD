<?php
// db_connection.php
function getDatabaseConnection()
{
    $host = 'localhost';
    $dbname = 'eclassrecord';
    $username = 'root';  // Adjust as per your database configuration
    $password = '';      // Adjust as per your database configuration

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Log error or handle connection failure
        error_log("Database Connection Error: " . $e->getMessage());
        return null;
    }
}

// Helper function to safely fetch data
function fetchData($query, $params = [])
{
    $pdo = getDatabaseConnection();
    if (!$pdo) {
        return ['error' => 'Database connection failed'];
    }

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Query Error: " . $e->getMessage());
        return ['error' => 'Query execution failed'];
    }
}
?>