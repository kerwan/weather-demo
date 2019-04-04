<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/app.css">
        <script type="text/javascript" src="/js/app.js"></script>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
        integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin=""/>

        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
        integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
        crossorigin=""></script>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
          var map = L.map('map').setView([{{$lat}}, {{$lon}}], 13);
          var OpenStreetMap_France = L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
          	maxZoom: 20,
          	attribution: '&copy; Openstreetmap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(map);

          var marker = L.marker([{{$lat}}, {{$lon}}], { title: "{{ $current_weather->name }}" }).addTo(map);
        });
        </script>

        <title>{{ Lang::get('weather.check_the_weather_in_your_city') }}</title>

    </head>

    <body>

      <div class="city-weather">

        <div class="city-infos">
          <div class="city-name">{{ $current_weather->name }}</div>
        </div>


        <div class="weather">
          <img class="weather-icon" src="http://openweathermap.org/img/w/{{ $current_weather->weather[0]->icon }}.png">
          <span class="description">{{ ucfirst($current_weather->weather[0]->description) }}</span>
        </div>

        <div class="temperature">
          <div class="temperature-current">
            <span class="temperature-title">{{ Lang::get('weather.now') }} : </span>
            <span class="value">{{ $current_weather->main->temp }}</span>
            <span class="unit">&#8451;</span>
          </div>
          <div class="temperature-min">
            <span class="temperature-title">{{ Lang::get('weather.temp_min') }} : </span>
            <span class="value">{{ $current_weather->main->temp_min }}</span>
            <span class="unit">&#8451;</span>
          </div>
          <div class="temperature-max">
            <span class="temperature-title">{{ Lang::get('weather.temp_max') }} : </span>
            <span class="value">{{ $current_weather->main->temp_max }}</span>
            <span class="unit">&#8451;</span>
          </div>
        </div>

      </div>

      <div class="city-search">
        <form action="{{ URL::to('current-weather') }}" method="GET">
          <input type="text" name="city" value="" placeholder="{{ Lang::get('weather.search_a_city') }}">
        </form>
      </div>

      <div id="map"></div>

    </body>
</html>
