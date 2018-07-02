<?php

namespace Controller;

use Model\ProgramDao;

require_once "getQuestionsController.php";
require_once '../Model/ProgramDao.php';

//Class that gets the decoded json array and divides it into smaller subarrays
class QuestionLogic {

    private $category;
    public $questionsArray = [];
    public $answersArray = [];

    public function __construct($choice) {
        $this->category = $choice;
    }

    public function divideIntoArrays() {
        $mainArray = self::getMainArray();
        $rightAnswersArray = [];

        for($i = 0; $i < count($mainArray); $i++) {
            $this->questionsArray[] = html_entity_decode($mainArray[$i]['question']); 
            $this->answersArray[] = html_entity_decode($mainArray[$i]['incorrect_answers'][0]);
            $this->answersArray[] = html_entity_decode($mainArray[$i]['incorrect_answers'][1]);
            $this->answersArray[] = html_entity_decode($mainArray[$i]['incorrect_answers'][2]);
            $rightAnswersArray[] = html_entity_decode($mainArray[$i]['correct_answer']);
           
        }

        $count = 0;
        $count2 = 2;
        for($i = 0; $i < count($rightAnswersArray); $i++) {
            
            $rnd= mt_rand($count, $count2);
            $this->answersArray = $this->insert($this->answersArray, $rnd, $rightAnswersArray[$i]);
            $count = $count + 4;
            $count2 = $count2 + 4;
                     
        }
        
        
    }
        
    public function getMainArray() {
        $linkArray = ["https://opentdb.com/api.php?amount=10&category=23&difficulty=hard&type=multiple", "https://opentdb.com/api.php?amount=10&category=18&difficulty=medium&type=multiple", 
                                                            "https://opentdb.com/api.php?amount=10&category=9&difficulty=hard&type=multiple"];
        
        switch ($this->category) {
            case "1":
                $link = $linkArray[0];
                break;
            case "2":
                $link = $linkArray[1];
                break;
            case "3":
                $link = $linkArray[2];
                break;
            default:
                break;
        }
        

        GetQuestions::$url = $link;
        $megaArray = GetQuestions::getContent();
        $smallerArray = $megaArray['results'];
        return $smallerArray;
    }
    
    //Main logic behind the random insertion of correct answers
    public function insert($array, $index, $val)
    {
        $size = count($array); 
        if (!is_int($index) || $index < 0 || $index > $size)
        {
            return -1;
        }
        else
        {
            $temp   = array_slice($array, 0, $index);
            $temp[] = $val;
            return array_merge($temp, array_slice($array, $index, $size));
        }
    }
        


}

  
//The form points directly to the class 
if(isset($_POST["data_category"])) {
    
    $choice = $_POST["data_category"];
    $check = new QuestionLogic($choice);
    $check->divideIntoArrays();
    $pdo = new ProgramDao();
    
    switch ($choice) {
        case "1":
            $pdo->insertDataHistory($check->questionsArray, $check->answersArray);
            break;
        case "2":
            $pdo->insertDataComputers($check->questionsArray, $check->answersArray);
            break;
        case "3":
            $pdo->insertDataGeneral($check->questionsArray, $check->answersArray);
            break;
        default:
            break;
        
    }
    
    
    header("location: ../Controller/indexController.php?page=mainUpdated");
    
    
}

?>