<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Piscine Méteo - IMIE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <link href="registrationOrConection.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/8a3192b16c.js" crossorigin="anonymous"></script>
  </head>

  <body>
     <form action="controller_registration.php" method="post">
     <h2><i class="fas fa-smog"></i> Piscine | Météo</h2>
       <label for=""><i class="fas fa-signature"></i> Last Name</label>
       <input type="text" name="last_name" required>
       <label for=""><i class="fas fa-id-card"></i> First Name</label>
       <input type="text" name="first_name" required>
       <label for=""><i class="fas fa-envelope"></i> Mail</label>
       <input type="mail" name="mail" required>
       <label for=""><i class="fas fa-lock"></i> Password</label>
       <input type="password" name="passwd" required>
       <input type="submit" value="S'inscrire">
     </form> 
  </body>
  </html>
