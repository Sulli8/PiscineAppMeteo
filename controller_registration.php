<?php 
require_once("manager.php");
$manager = new manager();

if(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
    $manager->registrationUser($_POST);
}
else{
    echo "Erreur ! ";
}


?> 