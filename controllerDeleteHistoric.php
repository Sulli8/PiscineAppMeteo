<?php
require_once("manager.php");
$manager = new manager();
switch($_POST['AllHistorics']){
    case 0:
        $manager->deleteHistorics($_POST);
    case 1:
        $manager->deleteAllHistorics($_POST);
}

?>