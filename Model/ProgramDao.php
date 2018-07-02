<?php

namespace Model;


class ProgramDao
{

    const DB_IP = "127.0.0.1";
    const DB_PORT = "3306";
    const DB_NAME = "poll_project";
    const USER = "root";
    const PASS = "";
    private $pdo;

    public function __construct()
    {

        try {
            $this->pdo = new \PDO("mysql:host=" . self::DB_IP . ":" . self::DB_PORT . ";dbname=" . self::DB_NAME, self::USER, self::PASS);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            echo "There was a problem with the database - " . $e->getMessage();
        }
    }

    public function getQuestions($choice)
    {

        if ($choice == 1) {
            $query = $this->pdo->prepare("SELECT questions FROM questions_history");
            $query->execute();
            while ($resultRow = $query->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = html_entity_decode($resultRow['questions']);
            }
            return $result;
        }
        elseif($choice == 2) {
           $query = $this->pdo->prepare("SELECT questions FROM questions_computers");
           $query->execute();
           while ($resultRow = $query->fetch(\PDO::FETCH_ASSOC)) {
               $result[] = html_entity_decode($resultRow['questions']);
           }
           return $result;
        }
        else {
            $query = $this->pdo->prepare("SELECT questions FROM questions_general");
            $query->execute();
            while ($resultRow = $query->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = html_entity_decode($resultRow['questions']);
            }
            return $result;
        }

    }


    public function getAnswers($choice)
    {
        $result = [];

        if ($choice == 1) {
            $query = $this->pdo->prepare("SELECT answers FROM answers_history");
            $query->execute();
            while ($resultRow = $query->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = html_entity_decode($resultRow['answers']);
                
            }
            return $result;
        }
        elseif($choice == 2) {
           $query = $this->pdo->prepare("SELECT answers FROM answers_computers");
           $query->execute();
           while ($resultRow = $query->fetch(\PDO::FETCH_ASSOC)) {
               $result[] = html_entity_decode($resultRow['answers']);
           }
           return $result;
        }
        else {
            $query = $this->pdo->prepare("SELECT answers FROM answers_general");
            $query->execute();
            while ($resultRow = $query->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = html_entity_decode($resultRow['answers']);
            }
            return $result;
        }
    }
    
    
    public function checkLogin($username, $password)
    {
        
            $query = $this->pdo->prepare("SELECT COUNT(*) as rows FROM users WHERE username = ? AND password = ?");
            $query->execute(array($username, $password));
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            if($result['rows'] == 0) {
                return false;
            }
            else {
                return true;
            }
        
    }
    
    public function checkUsername($username) {
        
        $query = $this->pdo->prepare("SELECT COUNT(*) as rows FROM users WHERE username = ?");
        $query->execute(array($username));
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        if($result['rows'] == 0) {
            return false;
        }
        else {
            return true;
        }
    }
    
    public function registerUser($username, $pass) 
    {
        $query = $this->pdo->prepare("INSERT INTO users (username, password) VALUES(?, ?)");
        $query->execute(array($username, $pass));
        
    }
    
    
    
    public function insertDataComputers($questionArray, $answersArray) {
        for($i = 0; $i < count($questionArray); $i++) {
            $query = $this->pdo->prepare("UPDATE questions_computers SET questions = ? WHERE id = ?");
            $query->execute(array($questionArray[$i], $i+1));
        }
        
        for($i = 0; $i < count($answersArray); $i++) {
            $query = $this->pdo->prepare("UPDATE answers_computers SET answers = ? WHERE id = ?");
            $query->execute(array($answersArray[$i], $i+1));
        }
    }
    
    
    
    public function insertDataHistory($questionArray, $answersArray) {
        for($i = 0; $i < count($questionArray); $i++) {
            $query = $this->pdo->prepare("UPDATE questions_history SET questions = ? WHERE id = ?");
            $query->execute(array($questionArray[$i], $i+1));
        }
        
        for($i = 0; $i < count($answersArray); $i++) {
            $query = $this->pdo->prepare("UPDATE answers_history SET answers = ? WHERE id = ?");
            $query->execute(array($answersArray[$i], $i+1));
        }
    }
    
    
    public function insertDataGeneral($questionArray, $answersArray) {
        for($i = 0; $i < count($questionArray); $i++) {
            $query = $this->pdo->prepare("UPDATE questions_general SET questions = ? WHERE id = ?");
            $query->execute(array($questionArray[$i], $i+1));
        }
        
        for($i = 0; $i < count($answersArray); $i++) {
            $query = $this->pdo->prepare("UPDATE answers_general SET answers = ? WHERE id = ?");
            $query->execute(array($answersArray[$i], $i+1));
        }
        
    }
    


}
?>
