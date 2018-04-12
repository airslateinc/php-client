<?php

namespace AirSlate\ApiClient\Implementation\Laravel\Providers;

use AirSlate\ApiClient\Client;
use Illuminate\Support\ServiceProvider;

/**
 * Class ApiClientServiceProvider
 * @package AirSlate\ApiClient\Implementation\Laravel\Providers
 */
class ApiClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                \dirname($this->configPath()) => $this->app->make('path.config'),
            ], 'airslate-api');
        }

        $this->mergeConfigFrom($this->configPath(), 'airslate-api');
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

            /** @var \Illuminate\Contracts\Foundation\Application $app */
            $config = $app->make('config');
            return Client::instance(
                $config->get('airslate-api.base_uri'),
                [
                    'token' => $token
                ]
            );
        });
    }

    /**
     * Return config path.
     *
     * @return string
     */
    private function configPath(): string
    {
        return \dirname(__DIR__) . '/config/airslate-api.php';
    }
}
