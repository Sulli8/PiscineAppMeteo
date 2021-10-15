<?php


class manager{
    //on se connecte 
    function connexion_bd(){
        //ON déclare les variables d'environnement afin de cacher le informations de gestion de conneixon à la BDD
    
        //Informations database Hôte
        $env_host = "DB_HOST";
        putenv("$env_host=localhost");
        //putenv("$env_host=localhost:3306");
    
        //Informations database Name
        $env_name = "DB_NAME";
        putenv("$env_name=Weatherdb");
    
        //Informations database User
        $env_user = "DB_USER";
        putenv("$env_user=root");
        //putenv("$env_user=zqyw5494_snacklprs");
    
        //Informations database Pass
        $env_pass = "DB_PASS";
        putenv("$env_pass=root");
        //putenv("$env_pass=L8zIG62mweJ4x67UWC");
    
    
       try
       {
         $bdd = new PDO( 'mysql:host='.getenv($env_host).';dbname='.getenv($env_name).';charset=utf8',getenv($env_user),getenv($env_pass));
       }
       catch(Exception $e)
       {
         die('ERREUR:'.$e->getMessage());
       }
       return $bdd;
    }
    //Méthode qui permet de générer un chaine aléatoire
    function genererChaineAleatoire($longueur = 8, $listeCar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ?/!-_')
    {
        $chaine = '';
        $max = mb_strlen($listeCar, '8bit') - 1;
        //On parcours le tableau
        for ($i = 0; $i < $longueur; ++$i) {
            $chaine .= $listeCar[random_int(0, $max)];
        }
        return $chaine;
    }
    //on inscrit l'utilisateur
    function registrationUser($args){
        $pdo = $this->connexion_bd();
        $requestRegistration = $pdo->prepare("INSERT INTO User(last_name,first_name,mail,passwd,SessionId) VALUES(?,?,?,?,?)");
        $requestRegistration->execute(array(
        $args['last_name'],
        $args['first_name'],
        $args['mail'],
        $this->encrypt($args['passwd'],$this->encryptionKey()),
        $this->genererChaineAleatoire()
    ));

    if($requestRegistration){
        header("Location:index.php");
    }
    else{
    echo "Error";
    }
}
  //Clé qui permet le cryptage de mot de passe
function encryptionKey(){
    $private_secret_key = '1f4276388ad3214c873428dbef42243f';
    return $private_secret_key;
}
   //Méthode qui permet de crypter un mot de passe
   function encrypt(string $message, string $encryption_key)
   {
       $key = hex2bin($encryption_key);
       $nonceSize = openssl_cipher_iv_length('aes-256-ctr');
       $nonce = openssl_random_pseudo_bytes($nonceSize);

       $ciphertext = openssl_encrypt(
           $message,
           'aes-256-ctr',
           $key,
           OPENSSL_RAW_DATA,
           $nonce
       );
       return base64_encode($nonce . $ciphertext);
   }

   //Méthode qui permet de décrypter un mot de passe
   function decrypt(string $message, string $encryption_key)
   {
       //On déclare une clé en binaire
       $key = hex2bin($encryption_key);
       $message = base64_decode($message);
       $nonceSize = openssl_cipher_iv_length('aes-256-ctr');
       $nonce = mb_substr($message, 0, $nonceSize, '8bit');
       $ciphertext = mb_substr($message, $nonceSize, null, '8bit');
       //Méthode algorythmique de cryptage de mot de passe
       $plaintext = openssl_decrypt(
           $ciphertext,
           'aes-256-ctr',
           $key,
           OPENSSL_RAW_DATA,
           $nonce
       );
       return $plaintext;
   }

//Méthode de connexion utilisateur 
function connectionUser($args){
    $pdo = $this->connexion_bd();
   
    $selectRequestRegistration = $pdo->prepare("SELECT passwd from User WHERE mail = ? ");
        $selectRequestRegistration->execute(array($args['mail']));
        $reqPass = $selectRequestRegistration->fetch();
        if($reqPass != false){
            if(!empty(sizeof($reqPass)) && $this->decrypt($reqPass["passwd"],$this->encryptionKey()) == $args['passwd']){
            $genereid = $this->genererChaineAleatoire(20);
            //On modifie son id par rapport à son mail
            $mail = $args['mail'];
            $request = $pdo->prepare("UPDATE User set SessionId=:SessionId WHERE mail='$mail'");
            $insert_genereId = $request->execute(array(
                'SessionId' => $genereid
            ));

            session_start();
            $_SESSION['id'] = $genereid;
            header("Location:index.php");
        }
    }
        else{
            echo "Error Connection";
        }

}
//méthode de modification de donnée 
function UpdateDataUser($args){
    $pdo = $this->connexion_bd();
    session_start();
    $select = $pdo->prepare("SELECT idUser from User WHERE SessionId = ? ");
    $select->execute(array($_SESSION['id']));
    $idUSer = $select->fetch()['idUser'];
    $UpdateDataUser = $pdo->prepare("UPDATE User set last_name = ?,first_name = ?,mail = ?,passwd = ? WHERE idUser = ? ");
    $UpdateDataUser->execute(array($args['last_name'],
        $args['first_name'],
        $args['mail'],
        $this->encrypt($args['passwd'],$this->encryptionKey()),
        $idUSer
    ));
    header("Location:manageAccount.php");
}
//Méthode d'insertion de météo
    function registrationWeather($args){
        $pdo = $this->connexion_bd();

        //On vérifie si la ville existe dans la base 
        $selectRequestRegistration = $pdo->prepare("SELECT * from City WHERE name = ?");
        $selectRequestRegistration->execute(array($args['nameCity']));
        $req = $selectRequestRegistration->fetch();
        
        if($req){
            if($req['name'] === $args['nameCity']){
                $selectRequestRegistration = $pdo->prepare("SELECT idCity from City WHERE name = ?");
                $selectRequestRegistration->execute(array($args['nameCity']));
                
                $selectRequestRegistrationWeather = $pdo->prepare("SELECT * from Weather WHERE City_idCity = ?");
                $selectRequestRegistrationWeather->execute(array($selectRequestRegistration->fetch()['idCity']));
                
                if(sizeof($selectRequestRegistrationWeather->fetch()) != 0){
                    $this->registeredHistorics($args['nameCity']);
                    die("Cette meteo existe dans le base !");
                }
                else{
                    $requestRegistration = $pdo->prepare("INSERT INTO Weather(tmp,description,humidity,time_zone,latitude,longitude,speed_wind,deg_wind,City_idCity,icon) VALUES(?,?,?,?,?,?,?,?,?,?)");
                        $requestRegistration->execute(array(
                        $args['temp'],
                        $args['description'],
                        $args['humidity'],
                        $args['timezone'],
                        $args['latitude'],
                        $args['longitude'],
                        $args['speed_wind'],
                        $args['deg_wind'],
                        $selectRequestRegistration->fetch()['idCity'],
                        $args['icon']
                    ));

                    $this->registeredHistorics($args['nameCity']);
                }
                
            }
           
        }
        else{
                    //sinon on insert la ville et sa méteo 
            $requestRegistration = $pdo->prepare("INSERT INTO City(name) VALUES(?)");
            $requestRegistration->execute(array(
                $args['nameCity']
            ));

            $selectRequestRegistration = $pdo->prepare("SELECT idCity from City WHERE name = ?");
            $selectRequestRegistration->execute(array($args['nameCity']));
            
            $requestRegistration = $pdo->prepare("INSERT INTO Weather(tmp,description,humidity,time_zone,latitude,longitude,speed_wind,deg_wind,City_idCity,icon) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $requestRegistration->execute(array(
                $args['temp'],
                $args['description'],
                $args['humidity'],
                $args['timezone'],
                $args['latitude'],
                $args['longitude'],
                $args['speed_wind'],
                $args['deg_wind'],
                $selectRequestRegistration->fetch()['idCity'],
                $args['icon']
            ));
            $this->registeredHistorics($args['nameCity']);
        }

      
       
    }
    //Méthode qui permet de stocker l'historique du user
    function registeredHistorics($name){
        $pdo = $this->connexion_bd();
        define("TIMEZONE","Europe/Paris");
        date_default_timezone_set(TIMEZONE);
        $Object = new DateTime();
        $DateAndTime = $Object->format("Y-m-d h:i:s"); 
        $selectRequestIdCity = $pdo->prepare("SELECT idCity,Weather.idWeather as idWeather from City INNER JOIN Weather ON City.idCity = Weather.City_idCity WHERE City.name = ?");
        $selectRequestIdCity->execute(array($name));
        $reqSelectId = $selectRequestIdCity->fetch();
        $IdCity = $reqSelectId['idCity'];
        $IdWeather = $reqSelectId['idWeather'];

        $args = array('time'=>$DateAndTime,
        'City_idCity'=>$IdCity,
        'Weather_idWeather'=>$IdWeather
        );
        $this->historics($args);
    }
    //méthode qui permet l'insertion de l'historique 
    function historics($args){
        $pdo = $this->connexion_bd();
           //On enregistre les données dans l'historique 
           session_start();
           $SelectHistorical = $pdo->prepare("SELECT idUser FROM User WHERE User.SessionId = ?");
           $SelectHistorical->execute(array($_SESSION['id']));

           $requestRegistrationHistorical = $pdo->prepare("INSERT INTO Historical(Time,City_idCity,Weather_idWeather,idUSer) VALUES(?,?,?,?)");
               $requestRegistrationHistorical->execute(array(
                   $args['time'],
                   $args['City_idCity'],
                   $args['Weather_idWeather'],
                   $SelectHistorical->fetch()['idUser']
               ));
               die("Historique inséré");
    }

    function AddFavourites($args){
        $pdo = $this->connexion_bd();
        session_start();
        $SelectRequestFavourites = $pdo->prepare("SELECT idCity From City Where name = ?");
        $SelectRequestFavourites->execute(array($args['nameCity']));

        $SelectRequestIdUSer = $pdo->prepare("SELECT idUser from User Where SessionId = ?");
        $SelectRequestIdUSer->execute(array($_SESSION['id']));

        $idUser = $SelectRequestIdUSer->fetch()['idUser'];
        $idCity = $SelectRequestFavourites->fetch()['idCity'];

        $requestInsertFavourites = $pdo->prepare("INSERT INTO favourite(User_idUser,City_idCity) VALUES(?,?) ");
        $requestInsertFavourites->execute(array($idUser,$idCity));

        die("Bien insérée");

    }

    function deleteHistorics($args){
        $pdo = $this->connexion_bd();
        $deleteHistoric = $pdo->prepare("DELETE FROM historical WHERE City_idCity = ? AND Weather_idWeather = ?");
        $deleteHistoric->execute(array(
            $args['idCity'],
            $args['idWeather']
        ));
        header("Location:viewHistorique.php");
        //die("Historique Supprimée ! ");
    }
   
    function deleteAllHistorics($args){
        $pdo = $this->connexion_bd();
        $deleteHistoric = $pdo->prepare(" DELETE FROM Historical WHERE idUser = (SELECT idUSer FROM User WHERE User.SessionId = ?)");
        $deleteHistoric->execute(array(
            $args['SessionId']
        ));
        header("Location:viewHistorique.php");
        //die("Historique Supprimée ! ");
    }


    function deleteFavourites($args){
        $pdo = $this->connexion_bd();
        $deleteFavourite = $pdo->prepare("DELETE FROM favourite WHERE City_idCity = ? ");
        $deleteFavourite->execute(array(
            $args['idCity'],
        ));
        header("Location:viewFavourites.php");
        //die("Historique Supprimée ! ");
    }
   
    function deleteAllFavourites($args){
        $pdo = $this->connexion_bd();
        $deleteFavourite = $pdo->prepare(" DELETE FROM favourite WHERE User_idUser = (SELECT idUSer FROM User WHERE User.SessionId = ?)");
        $deleteFavourite->execute(array(
            $args['SessionId']
        ));
        header("Location:viewFavourites.php");
        //die("Historique Supprimée ! ");
    }
}
?>