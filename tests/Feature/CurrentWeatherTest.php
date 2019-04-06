<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrentWeatherTest extends TestCase
{
  // for simplicity purpose we only test some word in the response
  // and not the DOM tree. If this becomes necessary, we can use
  // Laravel Dusk (https://laravel.com/docs/5.8/dusk)

  /**
  * Test that the default route doesn't return an error
  *
  * @return void
  */
  public function testDefaultRouteIsAvailable()
  {
    $response = $this->get('/');
    $response->assertStatus(200);
  }

  /**
  * Test that the default route with no params calls shows the current weather for the default city
  *
  * @return void
  */
  public function testDefaultRequestUsesTheCorrectCityAndLanguage()
  {
    $response = $this->get('/');
    // checking that default city is contained in the response
    $response->assertSeeText('Montpellier');
    // checking that language used in the response is the default one
    $response->assertSeeText('Now');
  }

  /**
  * Test that the default route with the city param set with an existent city works correctly
  *
  * @return void
  */
  public function testExistingCityRequest()
  {
    $response = $this->get('?city=Paris');
    // checking that requested city is contained in the response
    $response->assertSeeText('Paris');
    // checking that language used in the response is the default one
    $response->assertSeeText('Now');
  }

  /**
  * Test that the default route with the lang param set with an existent language works correctly
  *
  * @return void
  */
  public function testExistingLangageRequest()
  {
    $response = $this->get('?lang=fr');
    // checking that requested city is the default one
    $response->assertSeeText('Montpellier');
    // checking that language used in the response is the requested one
    $response->assertSeeText('Maintenant');
  }

}
