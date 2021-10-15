<?php 
//On appelle la fonction qui permet de modifier les informations de l'utilisateur 
require_once("manager.php");
$manager = new manager();
$manager->UpdateDataUser($_POST);

?>