<?php

namespace AirSlate\ApiClient\Implementation\Laravel\Providers;

use AirSlate\ApiClient\Client;
use AirSlate\ApiClient\Services\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Support\ServiceProvider;
use AirSlate\ApiClient\Http\Client as HttpClient;
use JMS\Serializer\SerializerBuilder;

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
            /** @var \Illuminate\Contracts\Foundation\Application $app */
            $config = $app->make('config');
            return Client::instance(
                $config->get('airslate-api.base_uri'),
                [
                    'token' => $this->app->get('request')->bearerToken()
                ]
            );
        });

        $this->app->singleton(HttpClient::class, function ($app) {
            $config = $app->make('config');

            return new HttpClient([
                'base_uri' => $config->get('airslate-api.base_uri'),
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);
        });

        $this->app->singleton(EntityManager\Annotation\Resolver::class, function ($app) {
            return new EntityManager\Annotation\Resolver(
                new AnnotationReader()
            );
        });

        $this->app->singleton(SerializerInterface::class, function () {
            return SerializerBuilder::create()->build();
        });

        $this->app->singleton(EntityManager::class, function ($app) {
            return new EntityManager(
                $app->get(HttpClient::class),
                $app->get(SerializerInterface::class),
                $app->get(EntityManager\Annotation\Resolver::class)
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
