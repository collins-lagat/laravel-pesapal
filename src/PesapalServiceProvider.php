<?php

namespace CollinsLagat\LaravelPesapal;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PesapalServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/pesapal.php' => config_path('pesapal.php'),
                ],
                'pesapal-config'
            );
        }

        Route::group([
            'prefix' => config('pesapal.path'),
            'namespace' => 'CollinsLagat\LaravelPesapal\Http\Controllers',
            'as' => 'pesapal.',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    public function register()
    {
        $this->app->singleton(Pesapal::class, function ($app) {
            return new Pesapal(
                config('pesapal.consumer_key'),
                config('pesapal.consumer_secret'),
                config('pesapal.is_live'),
                config('pesapal.callback_url')
            );
        });
    }
}
