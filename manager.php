<?php


class manager{
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
    session_destroy();
    header("Location:index.php");
}

    function registrationWeather($args){
        $pdo = $this->connexion_bd();

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
                    die("Cette meteo existe dans le base !");
                }
                else{
                    $requestRegistration = $pdo->prepare("INSERT INTO Weather(tmp,description,humidity,time_zone,latitude,longitude,speed_wind,deg_wind,City_idCity) VALUES(?,?,?,?,?,?,?,?,?)");
                        $requestRegistration->execute(array(
                        $args['temp'],
                        $args['description'],
                        $args['humidity'],
                        $args['timezone'],
                        $args['latitude'],
                        $args['longitude'],
                        $args['speed_wind'],
                        $args['deg_wind'],
                        $selectRequestRegistration->fetch()['idCity']
                    ));
                }
            }
           
        }
        else{
            $requestRegistration = $pdo->prepare("INSERT INTO City(name) VALUES(?)");
            $requestRegistration->execute(array(
                $args['nameCity']
            ));

            $selectRequestRegistration = $pdo->prepare("SELECT idCity from City WHERE name = ?");
            $selectRequestRegistration->execute(array($args['nameCity']));
            
            $requestRegistration = $pdo->prepare("INSERT INTO Weather(tmp,description,humidity,time_zone,latitude,longitude,speed_wind,deg_wind,City_idCity) VALUES(?,?,?,?,?,?,?,?,?)");
            $requestRegistration->execute(array(
                $args['temp'],
                $args['description'],
                $args['humidity'],
                $args['timezone'],
                $args['latitude'],
                $args['longitude'],
                $args['speed_wind'],
                $args['deg_wind'],
                $selectRequestRegistration->fetch()['idCity']
            ));

            die("city bien insérée");
        }
    
    }
}
?>