<?php 
//On appelle la fonction qui permet de modifier les informations de l'utilisateur 
require_once("manager.php");
$manager = new manager();

if(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
    $manager->UpdateDataUser($_POST);
}
else{
    echo "Erreur de mail !";
}


?>