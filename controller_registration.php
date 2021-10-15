<?php 


//On appelle la fonction qui permet l'insertion user avec $_POST
require_once("manager.php");
$manager = new manager();
//on vérifie le mail avec filter_var
if(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
    $manager->registrationUser($_POST);
}
else{
    echo "Erreur ! ";
}


?> 