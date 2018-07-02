<?php

namespace Controller;

//This class returns the decoded json array from the Trivia API
class getQuestions {

    public static $url;


    private function __construct() {
    }

    public static function getContent() {
        ini_set("allow_url_fopen", 1);
        $mainArray = file_get_contents(self::$url);
        $mainArray = json_decode($mainArray, true);
        return $mainArray;
    }


}
?>