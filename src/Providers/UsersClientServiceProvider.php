<?php

namespace AirSlate\UsersManagement\Providers;

use AirSlate\UsersManagement\Client;
use Illuminate\Support\ServiceProvider;

class UsersClientServiceProvider extends ServiceProvider
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
