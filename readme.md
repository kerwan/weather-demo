# Weather Check Demo

Simple weather checking application for a city using Laravel, leaflet and OpenWeatherMap API

### Prerequisites

PHP >= 7.1.3

Composer

Apache or NGINX

### Installing

Clone the repo

```
git clone https://github.com/kerwan/weather-demo.git
```

Install dependencies with composer

```
composer install
```

After installing Laravel, you should configure your web server's document / web root to be the public directory. The index.php in this directory serves as the front controller for all HTTP requests entering your application.

Copy .env.example to .env

```
cp .env.example .env
```

Generate app key

```
artisan key:generate
```

For more info check [Laravel install doc](https://laravel.com/docs/5.8/installation)

## Running the tests

in command line run

```
phpunit
```

## Built With

* [Laravel](https://laravel.com/) - The web framework used
* [Leaflet](https://leafletjs.com/) - Interactive JS maps
* Love

## Authors

**Aurélien Peronnet**

## License

See the [LICENSE.md](LICENSE.md) file for details
