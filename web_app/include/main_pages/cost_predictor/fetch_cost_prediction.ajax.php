<?php
session_start();
ob_start();
require_once '../../DbConnect.php';
// Set the content type to application/json
header('Content-Type: application/json');

// Retrieve the raw POST data
$rawData = file_get_contents('php://input');

// Decode the JSON data into a PHP array
$requestData = json_decode($rawData, true);
$json = array();
//$type = $rawData['type'];
try {
    $conn = new DbConnect();
    $conn = $conn->connect();
    if (is_string($conn)) {
        throw new Exception("Error connecting to database: " . $conn);
    }
    $json['content'] = get_content($conn);
    http_response_code(200);
} catch (Exception $e) {
    http_response_code(500);
    $json['content'] = $e;
} finally {
    die(json_encode($json));
}

function get_content($con)
{
    $sql = "SELECT sku, shipping_carriers, routes, FORMAT(estimated_price, 2), demurrage_bin, 
       IFNULL(FORMAT(demurrage_cost_prediction, 2), 0), location FROM demurrage_predictor_data";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}