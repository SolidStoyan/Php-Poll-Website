<?php
namespace Controller;

require_once '../Model/ProgramDao.php';
use Model\ProgramDao;

//The logic when a user tries to log in the website
class loginController
{
    
    private $username;
    private $pass;
    public $errorMessage;
    private $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

    public function __construct($username, $pass) {
        $this->username = $username;
        $this->pass = $pass;
        
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getPassword() {
        return $this->pass;
    }
    
    public function checkUsernameLength() {
        
        if(strlen($this->username) < 6) {
            $this->errorMessage = "The entered username must be at least 6 characters long!";
            return false;
        }
        elseif(strlen($this->username) > 50) {
            $this->errorMessage = "The entered username is too long!";
            return false;
        }
        else {
            return true;
        }
    }
    
    
    public function checkPasswordLength() {
        
        if(strlen($this->pass) < 6) {
            $this->errorMessage = "The entered password must be at least 6 characters long!";
            return false;
        }
        elseif(strlen($this->pass) > 20) {
            $this->errorMessage = "The entered password is too long!";
            return false;
        }
        else {
            return true;
        }
    }
    
    public function encryptPass($pass) {
        $this->pass = sha1($pass);
    }
    
    
    public function checkLogin() {
        $pdo = new ProgramDao();
        $result = $pdo->checkLogin($this->username, $this->pass);
        
        if($result == true) {
            $this->errorMessage = "Success!";
            return true;
        }
        elseif($result == false) {
            $this->errorMessage = "The username or password you have entered is incorrect!";
            return false;
        }
        
    }
    
    public function checkSpecialChars() {
        
        if(preg_match($this->pattern, $this->username) ===  1) {
            
            $this->errorMessage = "You have entered invalid characters in the username!";
            return false;
        }
        elseif (preg_match($this->pattern, $this->pass) === 1) {
            
            $this->errorMessage = "You have entered invalid characters in the password!";
            return false;
        }
        else {
            
            return true;
        }
        
    }
    
    
    
    
    
}

?>