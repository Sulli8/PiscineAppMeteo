<?php
require_once("manager.php");
//on check le tableau de données envoyées 
//on apelle la fonction qui permet d'ajouter les favoris
if(isset($_POST) && !empty($_POST)){
    $manager = new manager();
    $manager->AddFavourites($_POST);
}

?>