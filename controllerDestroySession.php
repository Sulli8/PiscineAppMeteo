<?php
require_once("manager.php"); 
session_start();
//on modifie le sessionIs de l'utilisateur et on lui affecte un valeur de 0
$manager = new manager();
$pdo = $manager->connexion_bd();
        $requestRegistration = $pdo->prepare("UPDATE user SET SessionId = 0 WHERE SessionId = ?");
        $requestRegistration->execute(array($_SESSION['id']));
session_destroy();

//on redirige l'utilisateur
header("Location:index.php");
?>