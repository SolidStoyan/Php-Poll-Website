<?php
namespace Controller;

require_once 'registerController.php';
require_once '../Model/ProgramDao.php';
session_start();

//Handles the ajax register call
$username = trim(htmlentities($_POST["username"]));
$pass = trim(htmlentities($_POST["password"]));
$rpass = trim(htmlentities($_POST["rpass"]));
$regObj = new registerController($username, $pass, $rpass);

if($regObj->checkUsernameLength() && $regObj->checkPasswordLength() && $regObj->checkSpecialChars() && $regObj->checkUsername()) {
    
    $regObj->encryptPasswords();
    
    if($regObj->checkPasswords()) {
        
    echo json_encode($regObj->errorMessage);
        
        
    }
    else {
        echo json_encode($regObj->errorMessage);
        
    }
    
    
}
else {
    echo json_encode($regObj->errorMessage);
    
}

?>