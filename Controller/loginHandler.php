<?php
namespace Controller;

require_once 'loginController.php';
require_once '../Model/ProgramDao.php';
session_start();


//Handles the login ajax call
$username = trim(htmlentities($_POST["username"]));
$pass = trim(htmlentities($_POST["password"]));
$loginObj = new loginController($username, $pass);

if($loginObj->checkUsernameLength() && $loginObj->checkPasswordLength() && $loginObj->checkSpecialChars()) {
    
    $loginObj->encryptPass($pass);
    
    if($loginObj->checkLogin() == true) {
        $_SESSION["logged_user"] = true;
        $_SESSION["test"] = "TEST"; 
        echo json_encode($_SESSION["logged_user"]);
        
    }
    else {
        echo json_encode($loginObj->errorMessage);
        
    }
        
        
}
else {
    echo json_encode($loginObj->errorMessage);
}

?>
