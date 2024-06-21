<?php
/* Global Variable */
$pepper = 'MpcuedoRbloj7n8';
//error_reporting(0);
/* Global Functions */
/**
 * Generates a random string to be used as a salt
 * @param $length int Length of the salt to generate. Default value 15 if not specified in function call
 * @return string Generated salt
 */

function saltGenerator($length = 15): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * Check if string is a valid email format
 * @param $email string The string to check
 * @return bool True if it's a valid email format | False otherwise
 */
function checkEmail(string $email): bool
{
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function getAllPages($profileId): bool|PDO|array
{
    $conn = new DbConnect();
    $conn = $conn->connect();
    if (!$conn){
        return $conn;
    }
    $stmt = $conn->prepare("SELECT * FROM pages JOIN profile_pages pp on pages.idPage = pp.idPage WHERE pp.idProfile = :profileId ORDER BY orderPage");
    $stmt->bindParam(':profileId', $profileId);
    $stmt->execute();
    $table = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $Pages = array();
    foreach ($table as $value) {
        $Pages[] = new Page($value);
    }
    return $Pages;
}

/**
 * @param $userId
 * @return string
 */
function getProfilePicture($userId): string
{
    return '/Logimo/images/profile/user_' . $userId . '.jpg';
}

function has_access($id_page, $id_user): bool
{

    return false;
}

function get_children(int $pageId): array | false
{
    $con = new DbConnect();
    $con = $con->connect();
    if ($con) {
        $stmt = $con->prepare("SELECT * FROM pages WHERE parent_id = :parent_id");
        $stmt->bindParam(":parent_id", $pageId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else{
        return false;
    }
}