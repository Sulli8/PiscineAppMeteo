<!DOCTYPE html>
<?php session_start(); ?>
<html lang="fr">
  <head>
    <title>Piscine Méteo - IMIE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="">
  </head>
  <body>
      <?php 
      //On vérifie si l'utilisateur est connecté 
      //sinon on le redirige sur une autre page
      if(isset($_SESSION['id'])){
        include "weather_home.php";
      }
      else{
        include "forms_connection.php";
      }
      ?>
  </body>
  </html>
