<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\OpenWeather\OpenWeather;

class WeatherQueryController extends Controller
{

  public function showCurrentWeatherForCity() {

    // getting the requested city or setting back to default (Montpellier)
    $city = !empty(\Request::get('city')) ? \Request::get('city') : 'Montpellier';

    // setting back locale from the request or setting back to default (en)
    $this->checkAndSetLang(\Request::get('lang'));
    
    $openWeather = new OpenWeather(\Config::get('weather.api_key'), 'metric', \App::getLocale());
    $current_weather = $openWeather->getCurrentWeatherDataByCityName($city);

    return \View::make('weather.city', [
      'current_weather' => $current_weather,
      'lat' => $current_weather->coord->lat,
      'lon' => $current_weather->coord->lon,
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
