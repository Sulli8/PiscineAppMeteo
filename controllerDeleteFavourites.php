<?php
require_once("manager.php");
$manager = new manager();
//on vérifie la valeur de l'index AllFavourites
switch($_POST['AllFavourites']){
    case 0:
        //on appelle la fonction qui supprimer un favoris 
        $manager->deleteFavourites($_POST);
    case 1:
        //on appelle la fonction qui supprimer tout les favoris
        $manager->deleteAllFavourites($_POST);
}

?>