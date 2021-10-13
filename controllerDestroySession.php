<?php
require_once("manager.php"); 
session_start();
$manager = new manager();
$pdo = $manager->connexion_bd();
        $requestRegistration = $pdo->prepare("UPDATE user SET SessionId = 0 WHERE SessionId = ?");
        $requestRegistration->execute(array($_SESSION['id']));
session_destroy();


header("Location:index.php");
?>