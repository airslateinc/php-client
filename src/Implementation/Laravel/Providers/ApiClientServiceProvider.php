<?php

namespace AirSlate\ApiClient\Implementation\Laravel\Providers;

use AirSlate\ApiClient\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use JMS\Serializer\SerializerBuilder;

/**
 * Class ApiClientServiceProvider
 * @package AirSlate\ApiClient\Implementation\Laravel\Providers
 */
class ApiClientServiceProvider extends ServiceProvider
{
    const HTTP_CLIENT_SERVICE_NAME = 'air-slate-http-client';

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
        $this->app->singleton(self::HTTP_CLIENT_SERVICE_NAME, function ($app) {
            /** @var Repository $config */
            $config = $app->make('config');

            return new Client([
                'base_uri' => $config->get('airslate-api.base_uri'),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $config->get('airslate-api.access_token'),
                ],
                'connect_timeout' => $config->get('airslate-api.connect_timeout', 30),
                'request_timeout' => $config->get('airslate-api.request_timeout', 30),
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
                $app->get(self::HTTP_CLIENT_SERVICE_NAME),
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
