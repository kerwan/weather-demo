<div class="lang-selector">
  <a class="{{ $lang == 'en' ? 'selected' : '' }}"
    title="{{ Lang::get('weather.check_this_website_in_english') }}"
    href="{{ '?'.http_build_query(['lang' => 'en', 'city' => $city]) }}">
    EN
  </a>
  |
  <a class="{{ $lang == 'fr' ? 'selected' : '' }}" 
    title="{{ Lang::get('weather.check_this_website_in_french') }}"
    href="{{ '?'.http_build_query(['lang' => 'fr', 'city' => $city]) }}">
    FR
  </a>
</div>
