<?php
namespace Controller;
require_once 'categoryController.php';
require_once '../Model/ProgramDao.php';


//This handler handles the ajax call
if(isset($_GET["value"])) {
    $value = $_GET["value"];
    
    $obj = new getDetails($value);
    $result = $obj->getData();
    echo json_encode($result);
}
?>