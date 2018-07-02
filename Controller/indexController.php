<?php
session_start();
require_once "../View/header.html";
static $whitelist = ["login", "main", "newTask", "register", "mainUpdated"];
static $blacklistLogged = ["login", "register"];

if (isset($_GET["page"]) && $_GET["page"] == "logout") {
    session_destroy();
    header("Location: ../Controller/indexController.php?page=login");
    die();
}

if (isset($error) && $error) {
    echo "<h1>$error</h1>";
    require_once "../View/register.html";
}

if(isset($_GET["page"])){    
    $page_name = $_GET["page"];
    if(isset($_SESSION["logged_user"])){
        
        try {
//             require_once "../View/navigation_logged.html";
            $page_name = $_GET["page"];
            
            if(!in_array($page_name, $whitelist)) {
                
                require_once "../View/navigation_logged.html";
                require_once "../View/main.html";
                throw new Exception("The following webpage cannot be found - ".$page_name);
            }
            elseif(in_array($page_name, $blacklistLogged)) {
                
                unset($_SESSION["logged_user"]);
                require_once "../View/navigation_not_logged.html";
                require_once "../View/$page_name.html";
            }
            else {
                require_once "../View/navigation_logged.html";
                require_once "../View/$page_name.html";
            }
        }
        catch (Exception $e) {
            echo "An error has occured: ".$e->getMessage(),"\n";
        }
        
        
    }
    else{
        if($_GET["page"] === "main") {
            require_once "../View/navigation_not_logged.html";
            header("Location: ../Controller/indexController.php?page=login");
        }
        else {
            try {
                require_once "../View/navigation_not_logged.html";
                $page_name = $_GET["page"];
                
                if(!in_array($page_name, $whitelist)) {
                    
                    require_once "../View/login.html";
                    throw new Exception("The following webpage cannot be found - ".$page_name);               
                }
                else {
                    require_once "../View/$page_name.html"; 
                }
                     
            }
            catch (Exception $e) {
                
                echo "An error has occured: ".$e->getMessage(),"\n";
            }
        }
    }
    
}else{
    require_once "../View/navigation_not_logged.html";
    require_once "../View/login.html";
}
require_once "../View/footer.html";

?>
