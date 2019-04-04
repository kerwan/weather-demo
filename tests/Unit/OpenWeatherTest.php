<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\OpenWeather\OpenWeather as OpenWeather;

class OpenWeatherTest extends TestCase
{
  /**
   * Basic test, creating class with minimal values
   *
   * @return void
   */
  public function testClassCreationWithMinimalValues()
  {
    $open_weather = new OpenWeather(\Config::get('weather.api_key'));
    $this->assertNotNull($open_weather);

    // checking that all values are set, filled with default values for optionnal ones
    $this->assertEquals($open_weather->getApiKey(), \Config::get('weather.api_key'));
    $this->assertEquals($open_weather->getUnits(), 'metric');
    $this->assertEquals($open_weather->getLang(), 'en');
  }

  /**
   * Basic test creating class with all values (required and optionnal)
   *
   * @return void
   */
  public function testClassCreationWithAllOptionnalValues()
  {
    $open_weather = new OpenWeather(\Config::get('weather.api_key'), 'imperial', 'fr');
    $this->assertNotNull($open_weather);

    // checking that all values are set, filled with default values for optionnal ones
    $this->assertEquals($open_weather->getApiKey(), \Config::get('weather.api_key'));
    $this->assertEquals($open_weather->getUnits(), 'imperial');
    $this->assertEquals($open_weather->getLang(), 'fr');
  }

  /**
   * Test creating class with empty api key
   *
   * @return void
   */
  public function testClassCreationWithEmptyApiKey()
  {
    $this->expectException(\InvalidArgumentException::class);
    $open_weather = new OpenWeather('');
  }

  /**
  * The constructor uses the setters so instead of testing invalid values in the constructor
  * we can tests only the setters for the optionnal values
  */

  /**
   * Test creating class with empty units
   *
   * @return void
   */
  public function testSetEmptyUnits()
  {
    $this->expectException(\InvalidArgumentException::class);
    $open_weather = new OpenWeather(\Config::get('weather.api_key'));
    $open_weather->setUnits('');
  }

  /**
   * Test creating class with invalid unit
   *
   * @return void
   */
  public function testSetInvalidUnits()
  {
    $this->expectException(\InvalidArgumentException::class);
    $open_weather = new OpenWeather(\Config::get('weather.api_key'));
    $open_weather->setUnits('non_existent_units');
  }

  /**
   * Test creating class with empty lang
   *
   * @return void
   */
  public function testSetEmptyLang()
  {
    $this->expectException(\InvalidArgumentException::class);
    $open_weather = new OpenWeather(\Config::get('weather.api_key'));
    $open_weather->setLang('');
  }

  /**
   * Test creating class with invalid lang
   *
   * @return void
   */
  public function testSetInvalidLang()
  {
    $this->expectException(\InvalidArgumentException::class);
    $open_weather = new OpenWeather(\Config::get('weather.api_key'));
    $open_weather->setUnits('non_existent_lang');
  }

}
