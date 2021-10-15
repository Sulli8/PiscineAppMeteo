<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Piscine Méteo - IMIE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <script src="https://kit.fontawesome.com/8a3192b16c.js" crossorigin="anonymous"></script>
    <link href="registrationOrConection.css" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>

  <script>
    function weatherBlock(id,uppercase,data){
 
 $(id).html(
   "<div class='searchWeatherUser'>"+
         "<h2><b>"+uppercase+"</b></h2>"
         +"<div>"+capitalizeFirstLetter(data.weather[0].description)+"</div>"
         +"<img style='display:block;margin:auto;' src='http://openweathermap.org/img/wn/"+data.weather[0].icon+"@2x.png'/>"
       +"<div style='font-size:30px;'>"+parseInt(data.main.temp)+"°</div>"
       +"<div style='font-size:30px;'>Max."+parseInt(data.main.temp_max)+"° Min."+parseInt(data.main.temp_min)+"°</div>"
       +"<div style='margin-top:10px;'>"
       +"<div>"+"Humidité "+data.main.humidity+" Timezone  "+data.timezone+" </div>"
       +"<div>"+"Latitude  "+data.coord.lat+" Longitude  "+data.coord.lon+"</div>"
       +"<div>"+"Vitesse Du vent  "+data.wind.speed+" Degré Du vent "+data.wind.deg+"</div>"
       +"</div>"
+"<div>"
       );
       }



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
          $("#title").hide();
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
    
  
      });
  }
function capitalizeFirstLetter(string){
  return string.charAt(0).toUpperCase() + string.slice(1);
}


$(document).ready(function(){

  $('#btnBackNo').hide();
  $('#btnBackNo').click(function(){
            $("#searchWeatherNoUser").show();
          $("#AllWeather").show();
          $("#title").show();
          $("#FormConnectionUser").hide();
          $('#btnBackNo').hide();
        });

  $('#btnConnection').click(function(){
   
          $("#searchWeatherNoUser").hide();
          $("#AllWeather").hide();
          $("#title").hide();
          $("#FormConnectionUser").show();
          $("#btnBackNo").show();
        });


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
        $("#weatherTitle").show();
        $(id).append(
          "<div style='padding:20px;margin-bottom:5px;width:auto;height:auto;border:1px solid #27ae60;border-radius:10px;margin-left:5px;'>"+
      "<h2><b>"+uppercase+"</b></h2>"
      +"<div>"+capitalizeFirstLetter(data.weather[0].description)+"</div>"
      +"<img style='display:block;margin:auto;' src='http://openweathermap.org/img/wn/"+data.weather[0].icon+"@2x.png'/>"
    +"<div style='font-size:30px;'> "+parseInt(data.main.temp)+"°</div>"
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
  <style>
    body{
      color:#fff;
      text-align:center;
    }
    .btnSearchUser{
      display:block;
      margin:auto;
      margin-top:10px;
      color:#27ae60;
      background:#fff;
      width:200px;
      padding:20px;
      border:none;
      border-radius:50px;
    }
    .btnBack{
    margin-top:10px;
    background:#27ae60;
    color:#fff;
    width:100px;
    padding:7px;
    border:none;
    border-radius:10px;
  }
  </style>
  <body>
  <button style="margin-bottom:10px;" id='btnBackNo' class="btnBack"><i class="fas fa-arrow-circle-left"></i> Retour </button>
  <form style="display:none;" id="FormConnectionUser" action="controllerConnection.php" method="post">
    <h2><i class="fas fa-smog"></i>  Piscine | Météo</h2>
       <label for=""><i class="fas fa-envelope"></i> Mail</label>
       <input type="mail" name="mail" required>
       <label for=""><i class="fas fa-lock"></i> Mot de passe</label>
       <input type="password" name="passwd" required>
       <input type="submit" value="Connection"/>
       <a style="margin-bottom:10px;"href="forms_registration.php">Vous n'avez pas de compte?</a>
  </form> 

  
<div id="searchWeatherNoUser">

  <div class="weatherContains">
  <button style="display:none;" class="btnBack" id="back">
    <i class="fas fa-arrow-circle-left"></i> Retour
  </button>
  <div id="searchUser">
     <input class='InputSearchUser' type="text" placeholder="Entrez une ville" id="searchWeather"/>
     <button class='btnSearchUser' onclick="ajaxData()" ><i class="fas fa-search"></i> Rechercher</button>
     <button class='btnSearchUser' id="btnConnection"><i class="fas fa-user"></i> Inscription / Connexion</button>
     
  </div>
    <div id="weather">
    </div>
  </div>
</div>

<div id='title'>
<h2 id="weatherTitle" style="display:none;text-align:center;color:#fff;"><i class="fas fa-cloud"></i><b> Méteo de toutes les villes</b></h2>
<div class="DisplayedAllWeather" id="AllWeather"></div>
</div>
  </div>
  </body>
  </html>
