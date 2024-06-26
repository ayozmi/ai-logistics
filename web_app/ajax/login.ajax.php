<?php
ob_start();
session_start();
extract($_POST);
require_once '../include/DbConnect.php';
require_once '../include/User.php';
require_once '../include/config.php';
$json = array();
$json['error'] = null;
$json['code'] = null;
try{
    if (!isset($email) OR !isset($password)){ // If variable don't exist
        throw new Exception("Please fill both fields!", 422);
    }
    if ($email == "" OR $password == ""){ // If variable is empty
        throw new Exception("Please fill both fields!", 422);
    }
//    Comment for easier debugging
//    TODO: Uncomment
/*
    if (isset($captchaResponse) && !empty($captchaResponse)) { // Check if Captcha is checked
        //Get verify response data
        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captchaResponse);
        $responseData = json_decode($verifyResponse);
        if (!$responseData->success) { // If response is not success
            throw new Exception("Robot verification failed, please try again!", 500);
        }
    } else { // If captcha not checked
        throw new Exception("Please check the Captcha checkbox!", 500);
    }
	*/
    $user = new User();
    $userData = $user->getUser($email);
    if (!$userData){ // If false user doesn't exist
        throw new Exception("Wrong Credentials!", 422);
    }
    if (!$user->checkPassword($password, $userData['passwordHash'], $userData['passwordSalt'], $pepper)){ // If false passwords don't match
        throw new Exception("Wrong Credentials!" . $userData['passwordSalt'], 422);
    }
    $user->initializeVariables($userData);
    $_SESSION['user'] = serialize($user); // User for the actual session
}
catch (Exception $exception){
    $json['error'] = $exception->getMessage();
    $json['code'] = $exception->getCode();
}
echo json_encode($json);
