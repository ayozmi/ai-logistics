<?php
session_start();
ob_start();
require_once "../../DbConnect.php";
// Set the content type to application/json
header('Content-Type: application/json');
// Retrieve the raw POST data
$rawData = file_get_contents('php://input');

// Decode the JSON data into a PHP array
$requestData = json_decode($rawData, true);
$json = array();

// If this is accessed from the dashboard get only 2 latest news otherwise we will take into consideration
$conn = get_connection();

$json['content'] = get_content($conn, $requestData['type']);
die(json_encode($json));
function get_connection(){
    try {
        $conn = new DbConnect;
        return $conn->connect();
    }
    catch(PDOException $e){
        die($e);
    }
}

function get_content($con, $type){
    if($type == 1){
        $sql = "SELECT title, location, DATE_FORMAT(date, '%d-%m-%Y') as date, link FROM news ORDER BY date DESC LIMIT 2";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    else if ($type == 2){
        $sql = "SELECT title, text, location, classification, type, DATE_FORMAT(date, '%d-%m-%Y') as date_col, 
       link, summary, CONCAT(UPPER(LEFT(ml_classification, 1)), LOWER(SUBSTRING(ml_classification, 2))) ml_classification, 
       relevance FROM news ORDER BY date desc";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}