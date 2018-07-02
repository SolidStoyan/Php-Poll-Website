<?php
namespace Controller;

require_once '../Model/ProgramDao.php';
require_once 'dataHandler.php';

//This class gets the questions and answers from the database  
class getDetails {
    
    private $choice;
    private $questions = array();
    private $answers = array();

    public function __construct($choice) {
        $this->choice = $choice;
    }

    
    public function getData() {
        $pdo = new \Model\ProgramDao();
    
        $this->questions = $pdo->getQuestions($this->choice);
        $this->answers = $pdo->getAnswers($this->choice);
        
        $mainArray = array($this->questions, $this->answers);
        return $mainArray;
        
    }
}

?>
