<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Piscine Méteo - IMIE | Weather Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/8a3192b16c.js" crossorigin="anonymous"></script>

  </head>
  <script>
    // Define function to capitalize the first letter of a string
function capitalizeFirstLetter(string){
  return string.charAt(0).toUpperCase() + string.slice(1);
}

    $('#weather').hide();
    function ajaxData(){
      var post = document.getElementById('searchWeather').value;
      var search = "https://api.openweathermap.org/data/2.5/weather?q="+post+"&appid=7a398628daf0ce99c731ee47f87e3fb2&lang=fr"
      $.get(search, function( data ) {
        console.log(data);
        console.log(data.weather[0].icon);
        var uppercase = capitalizeFirstLetter($("#searchWeather").val());
        $('#weather').html(
          "<div style='font-size:20px;'>"+uppercase+"</div>"
          +"<div>"+capitalizeFirstLetter(data.weather[0].description)+"</div>"
          +"<img style='display:block;margin:auto;' src='http://openweathermap.org/img/wn/"+data.weather[0].icon+"@2x.png'/>"
        +"<div style='font-size:30px;'>"+data.main.temp+"°</div>"
        +"<div style='font-size:30px;'>Max."+data.main.temp_max+"° Min."+data.main.temp_min+"°</div>"
        +"<div style='margin-top:10px;'>"
        +"<div>"+"Humidity "+data.main.humidity+" Timezone  "+data.timezone+" </div>"
        +"<div>"+"Latitude  "+data.coord.lat+" Longitude  "+data.coord.lon+"</div>"
        +"<div>"+"Speed Wind  "+data.wind.speed+" Deg Wind  "+data.wind.deg+"</div>"
        +"</div>"
        );
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
        speed_wind : data.wind.speed,
        deg_wind: data.wind.deg
      }
      $.post( "controllerWeather.php",objectWeather)
      .done(function( data ) {
        console.log( "Data Loaded: " + data );
  });
  
      });

   


      }
  </script>

<style>
    body{
      background:#2c3e50;
      font-size:20px;
      font-family:sans-serif;
    }

    .Mainweather{
      margin:auto;
      transform:translateY(-50%,-50%);
      width:800px;
      height:auto;
      text-align:center;
      color:white;
    }

    .btnAccount{
      background:#27ae60;
      display:inline-block;
      margin-top:10px;
      color:#fff;
      width:200px;
      padding:20px;
      border:none;
      border-radius:50px;
    }

    .btnSearchUser{
      margin-top:10px;
      color:#27ae60;
      background:#fff;
      width:200px;
      padding:20px;
      border:none;
      border-radius:50px;
    }

    .weatherContains{
      margin-top:20px;
      border:3px solid #27ae60;
      border-radius:10px;
    }

    .InputSearchUser{
      display:block;
      margin:auto;
      background:#27ae60;
      color:#fff;
      width:200px;
      padding:20px;
      border:none;
      text-align:center;
      border-radius:50px;
    }
    #searchUser{
      margin-top:10px;
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

    #weather{
      margin-top:20px;
    }
  </style>
  <body>
   
<div class="Mainweather">
<div id="UserAccount">
      <button class="btnAccount">Nom user</button>
      <button class="btnAccount" onclick="location.href='manageAccount.php'">Voir mon compte </button>
      <button class="btnAccount">Voir mon historique </button>
      <button  class="btnAccount"onclick="location.href='controllerDestroySession.php'">Deconnexion</button>
    </div>

<div class="weatherContains">
  <button style="display:none;" class="btnBack" id="back">
    <i class="fas fa-arrow-circle-left"></i> Retour
  </button>
  <div id="searchUser">
    <h3>Cherchez une ville </h3>
     <input class='InputSearchUser' type="text" placeholder="Entrez une ville" id="searchWeather"/>
     <button class='btnSearchUser'value="Rechercher" onclick="ajaxData()" >Rechercher</button>
  </div>


    <div id="weather">

    </div>
    </div>
</div>





  
  </body>
  </html>
