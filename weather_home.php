<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Piscine Méteo - IMIE | Weather Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </head>

  <script>

    $('#weather').hide();
    function ajaxData(){
      var post = document.getElementById('searchWeather').value;
      var search = "https://api.openweathermap.org/data/2.5/weather?q="+post+"&appid=7a398628daf0ce99c731ee47f87e3fb2&lang=fr"
      $.get(search, function( data ) {
        console.log(data);
        $('#weather').html(
          "<h2> -- Weather -- </h2>"+
          "<div>"+"Description : "+document.getElementById("searchWeather").value+"</div>"
        +"<div>"+"Description : "+data.weather[0].description+"</div>"
        +"<div>"+"humidity : "+data.main.humidity+"</div>"
        +"<div>"+"Tmp : "+data.main.temp+"</div>"
        +"<div>"+"Timezone : "+data.timezone+"</div>"
        +"<div>"+"Latitude : "+data.coord.lat+"</div>"
        +"<div>"+"Longitude : "+data.coord.lon+"</div>"
        +"<div>"+"Speed Wind : "+data.wind.speed+"</div>"
        +"<div>"+"Deg Wind : "+data.wind.deg+"</div>");
        $('#weather').delay(800).show();

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
        alert( "Data Loaded: " + data );
  });
  
      });

   


      }
  </script>
  <body>
    <div>
      <button>Voir mon compte </button>
      <button onclick="location.href='controllerDestroySession.php'">Deconnexion</button>
    </br>
      Utilisateur : Nom User
    </div>

  <div id="searchUser">
    <label for="">Search a city</label>
     <input type="text"  id="searchWeather"/>
     <button value="Rechercher" onclick="ajaxData()" >Rechercher</button>
  </div>
  <div id="weather">
  </div>


  
  </body>
  </html>
