<?php

namespace AirSlate\ApiClient\Implementation\Laravel\Providers;

use AirSlate\ApiClient\FederatedSearchClient;
use Illuminate\Support\ServiceProvider;

/**
 * Class ApiFederatedSearchClientServiceProvider
 * @package AirSlate\ApiClient\Implementation\Laravel\Providers
 */
class ApiFederatedSearchClientServiceProvider extends ServiceProvider
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
            ], 'airslate-federated-search-api');
        }

        $this->mergeConfigFrom($this->configPath(), 'airslate-federated-search-api');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(FederatedSearchClient::class, function ($app) {
            /** @var \Illuminate\Contracts\Foundation\Application $app */
            $config = $app->make('config');
            return FederatedSearchClient::instance(
                $config->get('airslate-federated-search-api.base_uri'),
                [
                    'token' => $this->app->get('request')->bearerToken()
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
        return \dirname(__DIR__) . '/config/airslate-federated-search-api.php';
    }
}
