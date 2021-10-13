<?php
require_once("manager.php");
if(isset($_POST) && !empty($_POST)){
    $manager = new manager();
    $manager->registrationWeather($_POST);    
}


?>