<?php

namespace App\OpenWeather;

class OpenWeather
{

  /**
  * @var string openWeatherMap api key (you can get it by signing-in at https://home.openweathermap.org/users/sign_up)
  */
  private $api_key;

  /**
  * @var string Units used in the response: 'metric' or 'imperial'
  */
  private $units;

  /**
  * @var string Language used in the response for the description field
  */
  private $lang;

  /**
  * @var string Languages codes supported by the API
  */
  private static $available_langs = [
    'ar', // Arabic
    'bg', // Bulgarian
    'ca', // Catalan
    'cz', // Czech
    'de', // German
    'el', // Greek
    'en', // English
    'fa', // Persian (Farsi)
    'fi', // Finnish
    'fr', // French
    'gl', // Galician
    'hr', // Croatian
    'hu', // Hungarian
    'it', // Italian
    'ja', // Japanese
    'kr', // Korean
    'la', // Latvian
    'lt', // Lithuanian
    'mk', // Macedonian
    'nl', // Dutch
    'pl', // Polish
    'pt', // Portuguese
    'ro', // Romanian
    'ru', // Russian
    'se', // Swedish
    'sk', // Slovak
    'sl', // Slovenian
    'es', // Spanish
    'tr', // Turkish
    'ua', // Ukrainian
    'vi', // Vietnamese
    'zh_cn', // Chinese Simplified
    'zh_tw', // Chinese Traditional
  ];

  /**
  * @var string url for weather data
  */
  private $weather_url = 'https://api.openweathermap.org/data/2.5/weather';

  /**
  * Constructor
  *
  * @param string $api_key    OpenWeatherMap API key. Required.
  * @param string $units      Units used in the response (metric or imperial). Optionnal, 'metric' by default
  * @param string $lang       Language code for the description field. Optionnal, 'en' by default (must be in $available_langs array)
  */
  public function __construct($api_key, $units = 'metric', $lang = 'en') {
    // we use the setter here to raise any exception during constructor
    $this->setApiKey($api_key);
    $this->setUnits($units);
    $this->setLang($lang);
  }

  /**
  * Sets the API Key.
  *
  * @param string $apiKey API key.
  *
  */
  public function setApiKey($api_key) {
    if(empty($api_key)) {
      throw new \InvalidArgumentException('OpenWeather API key is missing');
    }

    $this->api_key = $api_key;
  }

  /**
  * Gets the API Key.
  *
  */
  public function getApiKey() {
    return $this->api_key;
  }

  /**
  * Sets the units.
  *
  * @param string $units units.
  *
  */
  public function setUnits($units) {
    if(!in_array($units, ['metric', 'imperial'])) {
      throw new \InvalidArgumentException('Units must be metric or imperial');
    }
    $this->units = $units;
  }

  /**
  * Gets the units.
  *
  */
  public function getUnits() {
    return $this->units;
  }

  /**
  * Sets the lang.
  *
  * @param string $lang language.
  *
  */
  public function setLang($lang) {
    if(!in_array($lang, self::$available_langs)) {
      throw new \InvalidArgumentException('Invalid language code '.$lang);
    }

    $this->lang = $lang;
  }

  /**
  * Gets the Language.
  *
  */
  public function getLang() {
    return $this->lang;
  }

  public function getCurrentWeatherDataByCityName($name = '') {
    // TODO: what about city name ambiguity (like Paris existing in both France and US) ?
    return $this->getWeatherData($this->weather_url, ['q' => $name]);
  }

  private function getWeatherData($url, $params) {

    $params['appid'] = $this->api_key;
    $params['units'] = $this->units;
    $params['lang'] = $this->lang;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $raw_data = curl_exec($ch);
    curl_close($ch);

    $weather_data = json_decode($raw_data);
    if ($weather_data === null && json_last_error() !== JSON_ERROR_NONE) {
      throw new Exception('Error while fetching data from openWeatherAPI');
    }

    // TODO: return instance of specialized class ?
    return $weather_data;
  }
}
