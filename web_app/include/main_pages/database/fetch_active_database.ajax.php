<?php
require '../../../vendor/autoload.php';
require '../../DbConnect.php';
session_start();
ob_start();
$json = array();
$json['error'] = null;
try {
    $conn = new DbConnect();
    $conn = $conn->connect();
    if (!$conn) {
        throw new Exception("Could not connect to database!", 500);
    }
    $stmt = $conn->prepare("SELECT `host_database`, `port_database`, `name_database`, `user_database`
                                FROM `logimo`.`database` WHERE active_database = 1;");
    $stmt->execute();
    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if a result was returned
    if ($result) {
        // Assign the fetched values to the $json array
        $json = array();
        $json["host"] = $result['host_database'];
        $json["database"] = $result['name_database'];
        $json["port"] = $result['port_database'];
        $json["user"] = $result['user_database'];
        // Output the JSON array
        echo json_encode($json);
    } else {
        $json = [];
        echo json_encode($json);
    }
} catch (Exception $exception) {
    $json["error"] = $exception->getMessage();
    http_response_code(500);
}