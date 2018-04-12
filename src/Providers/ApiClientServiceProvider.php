<?php

namespace AirSlate\ApiClient\Providers;

use AirSlate\ApiClient\Client;
use Illuminate\Support\ServiceProvider;

class ApiClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function ($app) {
            $authHeader = $this->app->get('request')->header('Authorization');
            $token = $authHeader ? explode(' ', $authHeader)[1] : '';

            return Client::getInstance('http://127.0.0.1', [
                'token' => $token
            ]);
        });
    }
}
