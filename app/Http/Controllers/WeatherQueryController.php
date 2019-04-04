<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\OpenWeather\OpenWeather;

class WeatherQueryController extends Controller
{

  private static $error_lat = '46.52863469527167';
  private static $error_lon = '2.43896484375';

  private static $default_zoom = 13;
  private static $error_zoom = 5;

  public function showCurrentWeatherForCity() {

    // getting the requested city or setting back to default (Montpellier)
    $city = !empty(\Request::get('city')) ? \Request::get('city') : 'Montpellier';

    // setting back locale from the request or setting back to default (en)
    $this->checkAndSetLang(\Request::get('lang'));

    $openWeather = new OpenWeather(\Config::get('weather.api_key'), 'metric', \App::getLocale());
    $current_weather = $openWeather->getCurrentWeatherDataByCityName($city);

    // any code other than 200 is an error
    $error = $current_weather->cod != "200";

    return \View::make('weather.city', [
      'error' => $error ? \Lang::get('weather.error_code_'.$current_weather->cod) : null,
      'city' => $error ? '' : $current_weather->name,
      'current_weather' => $current_weather,
      'lat' => $error ? self::$error_lat : $current_weather->coord->lat,
      'lon' => $error ? self::$error_lon : $current_weather->coord->lon,
      'zoom' => $error ? self::$error_zoom : self::$default_zoom,
    ]);
  }

  private function isSupportedLang($lang) {
    return in_array($lang, \Config::get('app.available_locales'));
  }

  private function checkAndSetLang($lang = null) {
    // set the new locale if it is supported or reverts to the fallback
    $lang = !empty($lang) && $this->isSupportedLang($lang) ?
            $lang : \Config::get('app.fallback_locale');
    \App::setLocale($lang);
  }

}
