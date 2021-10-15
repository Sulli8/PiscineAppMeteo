<?php
require_once("manager.php");
$manager = new manager();
switch($_POST['AllFavourites']){
    case 0:
        $manager->deleteFavourites($_POST);
    case 1:
        $manager->deleteAllFavourites($_POST);
}

?>