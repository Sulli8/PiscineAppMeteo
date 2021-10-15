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

      .Container{
        display:flex;
        flex-wrap:wrap;
        justify-content:center;
      }
      .ContainersHistorics{
        margin-top:10px;
        margin-left:10px;
        width:300px;
        height:auto;
        border-radius:20px;
        padding:20px;
        border:1px solid #27ae60;
        font-size:20px;
      }
      .textWeather{
          margin-top:10px;
          text-align:center;
      }

      .deleteFavourites{
        margin-left:93%;
        color:red;
        background:none;
        border:none;
        font-size:20px;
      }
      .btnFavourites{
        background:red;
        color:#fff;
        border:none;
        display:block;
        margin:auto;
        border-radius:50px;
        padding:20px;
      }
      .btnFavourites:hover{
        transition:0.5s;
        background:#fff;
        color:red;
      }
  </style>
  <script>

function DeleteFavourites(idCity,idWeather){
      data = {
        AllFavourites : 0,
        idCity : idCity,
        }
      $.post("controllerDeleteFavourites.php",data)
      .done(function( data ) {
       window.location.href = "viewFavourites.php";
        });
    }

    function DeleteAllFavourites(idSession){
      console.log(idSession);
      data = {
        AllFavourites : 1,
        SessionId:idSession
        }
        $.post("controllerDeleteFavourites.php",data)
      .done(function( data ) {
        window.location.href = "viewFavourites.php";
        
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
      $requestSelect = $pdo->prepare("SELECT * from City INNER JOIN Weather On Weather.City_idCity = City.idCity INNER JOIN favourite ON favourite.City_idCity = City.idCity INNER JOIN User on favourite.User_idUser = User.idUSer WHERE User.SessionId = ?");
      $requestSelect->execute(array($_SESSION['id']));
      $favourites = $requestSelect->fetchall();

    ?>
     <h2 style="text-align:center;"><i class="fas fa-smog"></i> Piscine | Favoris</h2>
     <?php if(empty($favourites)){    ?>
      <div style="text-align:center;font-size:15px;color:red;"><i class="fas fa-exclamation-triangle"></i> Aucun Favoris Disponible</div>
    <?php  } else {?>
      <button class="btnFavourites" onclick="DeleteAllFavourites('<?php echo $_SESSION['id'];?>')"><i class="fas fa-trash-alt"></i> Supprimer tous les favoris</button>
     <?php }?>
     <div class="Container">
     <?php
     //On boucle sur les favouris des météos de l'utilisateur afin d'afficher toutes les méteos del'utilisateur
     foreach($favourites as $key => $value){
     ?>
<div class="ContainersHistorics">
<button class="deleteFavourites" onclick="DeleteFavourites(<?php echo $value['idCity'];?>,<?php echo $value['idWeather'];?>)"><i class="fas fa-times"></i></button>
    <h1 style="text-align:center;"><b><?php echo ucfirst($value['name']);?></b></h1>
          <h2 style="text-align:center;"><b><?php echo $value['description'];?></b></h2>
          <?php $url = 'http://openweathermap.org/img/wn/'.$value['icon'].'@2x.png';?>
          <img style="display:block;margin:auto;"src="<?php echo $url;?>"/>
        <div style='text-align:center;font-size:30px;'><?php echo $value['tmp']."°";?></div>
        <div class="textWeather">
        
        <div>Humidité <?php echo $value['humidity'];?> Fuseau Horaire  <?php echo $value['time_zone'];?> </div>
        <div>Latitude  <?php echo $value['latitude'];?> </br> Longitude  <?php echo $value['longitude'];?></div>
        <div>Vitesse du vent  <?php echo $value['speed_wind'];?> Degré Vent  <?php echo $value['deg_wind'];?></div>
        </div>
</div>
<?php
}

?>
</div>
  </body>
  </html>
