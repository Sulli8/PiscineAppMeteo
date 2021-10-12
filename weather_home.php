<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Piscine Méteo - IMIE | Weather Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="">
  </head>
  <body>

     <form action="" >
     <label for="">Rechercher une ville</label>
     <input type="text" name="search" id="searchWeather"/>
     <input type="submit" id="btnSearch" value="Rechercher">
     </form> 
  <script>
    var search  = document.getElementById("searchWeather");
    var btnSearch  = document.getElementById('btnSearch');
    btnSearch.addEventListener("click",function(){
        window.location.href = "https://api.openweathermap.org/data/2.5/weather?q="+search.value+"&appid=7a398628daf0ce99c731ee47f87e3fb2";
    });
  </script>


<div> </div>
  </body>
  </html>
