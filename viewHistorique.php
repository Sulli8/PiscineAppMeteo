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
        height:300px;
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
     <h2 style="text-align:center;"><i class="fas fa-smog"></i> Piscine | Historique</h2>
     <?php 
     require_once("manager.php");
     $manager = new manager();
     $pdo = $manager->connexion_bd();
     $requestSelect = $pdo->prepare("SELECT * from User 
     INNER JOIN Historical ON User.idUser = Historical.idUser
     INNER JOIN City ON City.idCity = Historical.City_idCity 
     INNER JOIN Weather ON Weather.City_idCity = City.idCity
     WHERE  SessionId = ?");
     $requestSelect->execute(array($_SESSION['id']));
     $historique = $requestSelect->fetchall();

     foreach($historique as $key => $value){
 ?>
<div class="ContainersHistorics">
          <div style="text-align:center;"><?php echo $value['description'];?></div>
          <?php $url = 'http://openweathermap.org/img/wn/'.$value['icon'].'@2x.png';?>
          <img style="display:block;margin:auto;"src="<?php echo $url;?>"/>
        <div style='text-align:center;font-size:30px;'><?php echo $value['tmp']."°";?></div>
        <div class="textWeather">
        <div>City <?php echo $value['name'];?> </br> Time  <?php echo $value['Time'];?> </div>
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
