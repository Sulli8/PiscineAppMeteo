<?php
//on apelle la fonction qui permet la connexion
require_once("manager.php");
$manager = new manager();
$manager->connectionUser($_POST);

?>