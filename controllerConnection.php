<?php
//on apelle la fonction qui permet la connexion
require_once("manager.php");
$manager = new manager();

if(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
$manager->connectionUser($_POST);
}
else{
    echo "Erreur de mail";
}
?>