<?php
require_once("manager.php");
//On check les $_POST puis on appelle la fonction qui ajouter la méteo 
if(isset($_POST) && !empty($_POST)){
    $manager = new manager();
    $manager->registrationWeather($_POST);    
}


?>