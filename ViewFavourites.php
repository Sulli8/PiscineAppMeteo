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

  </head>
  <style>
      body{
          color:#fff;
          font-family:sans-serif;
      }
      .ContainersHistorics{
        margin-top:10px;
        width:300px;
        height:auto;
        border-radius:20px;
        padding:20px;
        border:3px solid #27ae60;
        display:inline-block;
        margin:auto;font-size:20px;
      }
      .textWeather{
          margin-top:10px;
          text-align:center;
      }
  </style>
  <body>
     <h2 style="text-align:center;"><i class="fas fa-smog"></i> Piscine |Favoris</h2>
     <?php 
     require_once("manager.php");
     $manager = new manager();
     //on appelle la méthode de connexion à la Base dedonnée 
     $pdo = $manager->connexion_bd();
     //On affiche les données d' l'historique de l'utilisateur
     $requestSelect = $pdo->prepare("SELECT * from City INNER JOIN Weather On Weather.City_idCity = City.idCity INNER JOIN favourite ON favourite.City_idCity = City.idCity INNER JOIN User on favourite.User_idUser = User.idUSer WHERE User.SessionId = ?");
     $requestSelect->execute(array($_SESSION['id']));
     $favourites = $requestSelect->fetchall();

     //On boucle sur l'historique des météos de l'utilisateur afin d'afficher toutes les méteos del'utilisateur
     foreach($favourites as $key => $value){
 ?>
<div class="ContainersHistorics">
    <h1 style="text-align:center;"><b><?php echo ucfirst($value['name']);?></b></h1>
          <h2 style="text-align:center;"><b><?php echo $value['description'];?></b></h2>
          <?php $url = 'http://openweathermap.org/img/wn/'.$value['icon'].'@2x.png';?>
          <img style="display:block;margin:auto;"src="<?php echo $url;?>"/>
        <div style='text-align:center;font-size:30px;'><?php echo $value['tmp']."°";?></div>
        <div class="textWeather">
        
        <div>Humidity <?php echo $value['humidity'];?> Timezone  <?php echo $value['time_zone'];?> </div>
        <div>Latitude  <?php echo $value['latitude'];?> </br> Longitude  <?php echo $value['longitude'];?></div>
        <div>Speed Wind <?php echo $value['speed_wind'];?> Deg Wind  <?php echo $value['deg_wind'];?></div>
        </div>
</div>
<?php
}

?>
  </body>
  </html>
