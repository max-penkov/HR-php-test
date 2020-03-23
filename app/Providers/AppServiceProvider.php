<?php

namespace App\Providers;

use App\services\WeatherInterface;
use App\services\WeatherHereService;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(WeatherInterface::class, function (Application $app) {
            $config = $app->make('config')->get('weather');

            switch ($config['driver']) {
                case 'here':
                    $params = $config['drivers']['here'];
                    return new WeatherHereService($params['app_code'], $params['app_id'], $params['lat'], $params['lng']);
                    break;
                default:
                    throw new \InvalidArgumentException('Undefined Weather driver ' . $config['driver']);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
