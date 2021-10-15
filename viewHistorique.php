<!DOCTYPE html>
<html lang="fr">
    <?php session_start();?>
  <head>
    <title>Piscine Méteo - IMIE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <link href="registrationOrConection.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/8a3192b16c.js" crossorigin="anonymous"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <style>
      body{
          color:#fff;
          font-family:sans-serif;
      }
      .ContainersHistorics{
        margin-top:10px;
        margin-bottom:10px;
        margin-left:5px;
        width:300px;
        height:auto;
        border-radius:20px;
        padding:20px;
        border:1px solid #27ae60;
        display:inline-block;
        font-size:20px;
      }
      .textWeather{
          margin-top:10px;
          text-align:center;
      }
      .Containers{
        display:flex;
        flex-wrap:wrap;
        justify-content:center;
      }
      .deleteHistorics{
        margin-left:93%;
        color:red;
        background:none;
        border:none;
        font-size:20px;
      }
      .btnHistoric{
        background:red;
        color:#fff;
        border:none;
        display:block;
        margin:auto;
        border-radius:50px;
        padding:20px;
      }
      .btnHistoric:hover{
        transition:0.5s;
        background:#fff;
        color:red;
      }
  </style>
  <script>
    //Cette fonction permet de supprimer un historique
    function DeleteHistorics(idCity,idWeather){
      data = {
        AllHistorics : 0,
        idCity : idCity,
        idWeather : idWeather
        }
      $.post("controllerDeleteHistoric.php",data)
      .done(function( data ) {
       window.location.href = "viewHistorique.php";
        });
    }
    //Cette fonction permet de supprimer tous les historique 
    function DeleteAllhistorics(idSession){
      console.log(idSession);
      data = {
        AllHistorics : 1,
        SessionId:idSession
        }
        $.post("controllerDeleteHistoric.php",data)
      .done(function( data ) {
        window.location.href = "viewHistorique.php";
        
        });
    }
  </script>
  <body>

  <?php
require_once("manager.php");
$manager = new manager();
//on appelle la méthode de connexion à la Base dedonnée 
$pdo = $manager->connexion_bd();
//On affiche les données d' l'historique de l'utilisateur
$requestSelect = $pdo->prepare("SELECT * from User 
INNER JOIN Historical ON User.idUser = Historical.idUser
INNER JOIN City ON City.idCity = Historical.City_idCity 
INNER JOIN Weather ON Weather.City_idCity = City.idCity
WHERE  SessionId = ?");
//DELETE FROM `Historical` WHERE `Historical`.`idHistorical` = 39 AND `Historical`.`City_idCity` = 38 AND `Historical`.`Weather_idWeather` = 26 
$requestSelect->execute(array($_SESSION['id']));
$historique = $requestSelect->fetchall();
  ?>
     <h2 style="text-align:center;"><i class="fas fa-smog"></i> Piscine | Historique</h2>
    <?php if(empty($historique)){    ?>
      <div style="text-align:center;font-size:15px;color:red;"><i class="fas fa-exclamation-triangle"></i> Aucun Historique Disponible</div>
    <?php  } else {?>
      <button class="btnHistoric" onclick="DeleteAllhistorics('<?php echo $_SESSION['id'];?>')"><i class="fas fa-trash-alt"></i> Supprimer tout l'historique</button>
     <?php }?>
     
     <div class="Containers">
     <?php 
     //"
     //On boucle sur l'historique des météos de l'utilisateur afin d'afficher toutes les méteos del'utilisateur
     foreach($historique as $key => $value){ ?>

<div class="ContainersHistorics">
  <button class="deleteHistorics" onclick="DeleteHistorics(<?php echo $value['idCity'];?>,<?php echo $value['idWeather'];?>)"><i class="fas fa-times"></i></button>
  <h2 style="text-align:center;"><b><?php echo ucfirst($value['name']);?></b></h2>
          <h4 style="text-align:center;"><b><?php echo ucfirst($value['description']);?></b></h4>
          <?php $url = 'http://openweathermap.org/img/wn/'.$value['icon'].'@2x.png';?>
          <img style="display:block;margin:auto;"src="<?php echo $url;?>"/>
        <div style='text-align:center;font-size:30px;'><?php echo intval($value['tmp'])."°";?></div>
        <div class="textWeather">
        <div> Date et Heure de la recherche :  <?php echo $value['Time'];?> </div>
        <div>Humidité <?php echo $value['humidity'];?> Fuseau Horaire <?php echo $value['time_zone'];?> </div>
        <div>Latitude  <?php echo $value['latitude'];?> </br> Longitude  <?php echo $value['longitude'];?></div>
        <div>Vitesse du vent <?php echo $value['speed_wind'];?> Degré Vent  <?php echo $value['deg_wind'];?></div>
        </div>
</div>
<?php
}

?>
</div>
  </body>
  </html>
