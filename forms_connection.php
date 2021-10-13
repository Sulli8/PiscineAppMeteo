<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Piscine Méteo - IMIE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <script src="https://kit.fontawesome.com/8a3192b16c.js" crossorigin="anonymous"></script>
    <link href="registrationOrConection.css" rel="stylesheet">

  </head>
  <body>
  <form action="controllerConnection.php" method="post">
    <h2><i class="fas fa-smog"></i> Piscine | Météo</h2>
       <label for=""><i class="fas fa-envelope"></i> Mail</label>
       <input type="mail" name="mail" required>
       <label for=""><i class="fas fa-lock"></i> Password</label>
       <input type="password" name="passwd" required>
       <input type="submit" value="Connection"/>
       <a href="forms_registration.php">Vous n'avez pas de compte?</a>
     </form> 
  </body>
  </html>
