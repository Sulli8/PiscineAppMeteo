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

  <body>
     <form action="controller_UpdateRegistration.php" method="post">
     <h2><i class="fas fa-smog"></i> Piscine | Météo</h2>
     <?php 
     require_once("manager.php");
     $manager = new manager();
     $pdo = $manager->connexion_bd();
     $requestSelect = $pdo->prepare("SELECT last_name,first_name,mail,passwd from User Where SessionId = ?");
     $requestSelect->execute(array($_SESSION['id']));
     $array = $requestSelect->fetch();
     $key  = array("Last Name","First Name","Mail","Password");
 ?>
    <label for=""><i class="fas fa-signature"></i> Nom </label>
     <input type="text" name='last_name' value=<?php echo $array['last_name']; ?> required>

     <label for=""><i class="fas fa-id-card"></i> Prénom </label>
     <input type="text" name="first_name" value=<?php echo $array['first_name']; ?> required>

     <label for=""><i class="fas fa-envelope"></i> Mail </label>
     <input type="mail" name="mail" value=<?php echo $array['mail']; ?> required>

     <label for=""><i class="fas fa-lock"></i> Mot de passe </label>
     <input type="text" name='passwd' value=<?php echo $manager->decrypt($array['passwd'],$manager->encryptionKey());?> required>
       <input type="submit" value="Modifier">
     </form> 
  </body>
  </html>
