<?php
require_once("manager.php");
$manager = new manager();
//on vérifie l'etat de 'lindex qui permet de savoir quel méthode appeler
switch($_POST['AllHistorics']){
    case 0:
        //on appelle la fonction qui supprime un historique
        $manager->deleteHistorics($_POST);
    case 1:
        //on apelle la fonction qui permet de supprimer touts les historiques
        $manager->deleteAllHistorics($_POST);
}

?>