<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Piscine Méteo - IMIE | Weather Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/8a3192b16c.js" crossorigin="anonymous"></script>
    <link href="weatherHome.css" rel="stylesheet">
  </head>
  <script>
    // Define function to capitalize the first letter of a string
function capitalizeFirstLetter(string){
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function weatherBlock(id,uppercase,data){
 
  $(id).html(
          "<h2><b>"+uppercase+"</b></h2>"
          +"<div>"+capitalizeFirstLetter(data.weather[0].description)+"</div>"
          +"<img style='display:block;margin:auto;' src='http://openweathermap.org/img/wn/"+data.weather[0].icon+"@2x.png'/>"
        +"<div style='font-size:30px;'>"+parseInt(data.main.temp)+"°</div>"
        +"<div style='font-size:30px;'>Max."+parseInt(data.main.temp_max)+"° Min."+parseInt(data.main.temp_min)+"°</div>"
        +"<div style='margin-top:10px;'>"
        +"<div>"+"Humidité "+data.main.humidity+" Timezone  "+data.timezone+" </div>"
        +"<div>"+"Latitude  "+data.coord.lat+" Longitude  "+data.coord.lon+"</div>"
        +"<div>"+"Vitesse Du vent  "+data.wind.speed+" Degré Du vent "+data.wind.deg+"</div>"
        +"</div>"+
        "<button style='margin-bottom:10px;'class='favourites' id='btnAddFavourites' > Ajouter aux favoris <i class='fas fa-star'></i></button>"

        );

        $('#btnAddFavourites').click((e) => {
          e.preventDefault();
          $('#btnAddFavourites').css({
            'background':'yellow'
          })

        var objectWeather = {
          nameCity : document.getElementById("searchWeather").value,
          description : data.weather[0].description,
          humidity : data.main.humidity,
          temp : data.main.temp,
          timezone : data.timezone,
          latitude: data.coord.lat,
          longitude : data.coord.lon,
          icon:data.weather[0].icon,
          speed_wind : data.wind.speed,
          deg_wind: data.wind.deg
      }
      
      $.post( "controllerAddFavourites.php",objectWeather)
      .done(function( data ) {
        console.log( "Data Loaded: " + data );
        
        });
  

    console.log("Favoris"+uppercase)
  })
}
    $('#weather').hide();
    function ajaxData(){
      var post = document.getElementById('searchWeather').value;
      var search = "https://api.openweathermap.org/data/2.5/weather?q="+post+"&units=metric&appid=c50475598345a95dd753f9eb0fd8f23e&lang=fr"
      $.get(search, function( data ) {
        console.log(data);
        console.log(data.weather[0].icon);
        var uppercase = capitalizeFirstLetter($("#searchWeather").val());
        weatherBlock('#weather',uppercase,data);
        $('#searchUser').hide();
        $('#weather').show();
        $('#back').show();

        $('#back').click(function(){
          $("#weather").hide();
          $('#back').hide();
          $('#searchUser').show();
        });

        var objectWeather = {
        nameCity : document.getElementById("searchWeather").value,
        description : data.weather[0].description,
        humidity : data.main.humidity,
        temp : data.main.temp,
        timezone : data.timezone,
        latitude: data.coord.lat,
        longitude : data.coord.lon,
        icon:data.weather[0].icon,
        speed_wind : data.wind.speed,
        deg_wind: data.wind.deg
      }
      $.post( "controllerWeather.php",objectWeather)
      .done(function( data ) {
        console.log( "Data Loaded: " + data );
  });
  
      });
  }

  $(document).ready(function(){  


    NameCityFrance = [];
      $.get("city.list.min.json",function(data){
      var AllCity = JSON.stringify(data);
      var objAllCity = JSON.parse(AllCity);
      for (let index = 0; index < objAllCity.length; index++) {
         if(objAllCity[index].country == 'FR'){
           NameCityFrance.push(objAllCity[index].name);
        }
      }

      for (let index = 0; index < 20; index++) {
        var search = "https://api.openweathermap.org/data/2.5/weather?q="+NameCityFrance[index]+"&units=metric&appid=c50475598345a95dd753f9eb0fd8f23e&lang=fr"
         $.get(search,function(data){
            data = JSON.stringify(data);
            data = JSON.parse(data)
            uppercase = capitalizeFirstLetter(NameCityFrance[index])
            id = "#AllWeather"
            $(id).append(
              "<div style='padding:10px;margin-bottom:5px;width:auto;height:auto;border:3px solid #27ae60;border-radius:10px;margin-left:5px;display:inline-block;justify-content:center;'>"+
          "<h2><b>"+uppercase+"</b></h2>"
          +"<div>"+capitalizeFirstLetter(data.weather[0].description)+"</div>"
          +"<img style='display:block;margin:auto;' src='http://openweathermap.org/img/wn/"+data.weather[0].icon+"@2x.png'/>"
        +"<div style='font-size:30px;'>"+parseInt(data.main.temp)+"°</div>"
        +"<div style='font-size:30px;'>Max."+parseInt(data.main.temp_max)+"° Min."+parseInt(data.main.temp_min)+"°</div>"
        +"<div style='margin-top:10px;'>"
        +"<div>"+"Humidité "+data.main.humidity+" Fuseau Horaire"+data.timezone+" </div>"
        +"<div>"+"Latitude  "+data.coord.lat+" Longitude  "+data.coord.lon+"</div>"
        +"<div>"+"Vitesse Du vent  "+data.wind.speed+" Degré du vent "+data.wind.deg+"</div>"
        +"</div>"+"</div>"
        );
          })

        
      }
    });
  });

 
  </script>
<!--<i style='color:white;' class='fas fa-star'></i>-->

  <body>
   
<div class="Mainweather">
<div id="UserAccount">
  <?php require_once("manager.php");
  $manager = new manager();
  $pdo = $manager->connexion_bd();
  $selectName = $pdo->prepare("SELECT * From User WHERE SessionId = ?");
  $selectName->execute(array($_SESSION['id']));
  $selectName = $selectName->fetch();
  ?>
      <button class="btnAccount"><i class="fas fa-user"></i> <?php echo ucfirst($selectName['first_name']); ?></button>
      <button class="btnAccount" onclick="location.href='manageAccount.php'"><i class="fas fa-tools"></i> Gérer mon compte </button>
      <button class="btnAccount" onclick="location.href='viewFavourites.php'"><i class="fas fa-eye"></i> Voir mes favoris </button>
      <button class="btnAccount" onclick="location.href='viewHistorique.php'"><i class="fas fa-eye"></i> Voir mon historique </button>
      <button  class="btnAccount" onclick="location.href='controllerDestroySession.php'"><i class="fas fa-power-off"></i> Deconnexion</button>
    </div>

<div class="weatherContains">
  <button style="display:none;" class="btnBack" id="back">
    <i class="fas fa-arrow-circle-left"></i> Retour
  </button>
  <div id="searchUser">
    <h3><i class="fas fa-search"></i> Cherchez une ville </h3>
     <input class='InputSearchUser' type="text" placeholder="Entrez une ville" id="searchWeather"/>
     <button class='btnSearchUser'value="Rechercher" onclick="ajaxData()" >Rechercher</button>
  </div>
    <div id="weather">
    </div>
  </div>
</div>

<h2 style="text-align:center;color:#fff;">
<i class="fas fa-cloud"></i>
<b>Méteo de toutes les villes</b>
  </h2>

<div class="DisplayedAllWeather" id="AllWeather">



</div>

  </body>
  </html>