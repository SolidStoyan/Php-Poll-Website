<?php
namespace Controller;

require_once '../Model/ProgramDao.php';
use Model\ProgramDao;

//Main logic used when the user tries to register
class registerController
{
    
    private $username;
    private $password;
    private $rpassword;
    public $errorMessage;
    private $pattern = '/[ \'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

    public function __construct($username, $pass, $rpass) {
        $this->username = $username;
        $this->password = $pass;
        $this->rpassword = $rpass;
        
    }
    
    public function checkUsernameLength() {
        
        if(strlen($this->username) < 6) {
            $this->errorMessage = "The entered username is too short!";
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
        
        if(strlen($this->password) < 6) {
            $this->errorMessage = "The entered password is too short!";
            return false;
        }
        elseif(strlen($this->password) > 20) {
            $this->errorMessage = "The entered password is too long!";
            return false;
        }
        else {
            return true;
        }
    }
    
    public function encryptPasswords() {
        $this->password = sha1($this->password);
        $this->rpassword = sha1($this->rpassword);
    }
    
    public function checkPasswords() {
        if($this->password === $this->rpassword) {
            $pdo = new ProgramDao();
            $pdo->registerUser($this->username, $this->password);
            $this->errorMessage = "You have successfully registered!";
            return true;
            
        }
        else {
            $this->errorMessage = "The entered passwords do not match!";
            return false;
        }
    }
    
    public function checkUsername() {
        $pdo = new ProgramDao();
        $result = $pdo->checkUsername($this->username);
        
        if($result) {
            $this->errorMessage = "The selected username already exists";
            return false;
        }
        else {
            return true;
            
        }
        
    }
    
    public function checkSpecialChars() {
        
        if(preg_match($this->pattern, $this->username) ===  1) {
            
            $this->errorMessage = "You have entered invalid characters in the username!";
            return false;
        }
        elseif (preg_match($this->pattern, $this->password) === 1 || preg_match($this->pattern, $this->rpassword) === 1) {
            
            $this->errorMessage = "You have entered invalid characters in the passwords!";
            return false;
        }
        else {
            
            return true;
        }
        
    }
    
}

?>