<?php
declare(strict_types=1);

namespace AirSlate\ApiClient;

use AirSlate\ApiClient\Http\Client as HttpClient;
use AirSlate\ApiClient\Services\FederatedSearchService;

/**
 * Class FederatedSearchClient
 * @package AirSlate\ApiClient
 */
class FederatedSearchClient
{
    /**
     * Client instances.
     *
     * @var HttpClient $instance
     */
    static private $instance;

    /**
     * @var FederatedSearchService $federatedSearchService
     */
    private $federatedSearchService;

    /**
     * Client constructor.
     *
     * @param string $baseUri
     * @param array $config
     *
     * config['token'] = '';
     * config['connectTimeout'] = 30; //default
     * config['requestTimeout'] = 30; //default
     */
    private function __construct(string $baseUri, array $config = [])
    {
        $httpClient = $this->configureClient($baseUri, $config);

        $this->federatedSearchService = new FederatedSearchService($httpClient);
    }

    /**
     * @param string $baseUri
     * @param array $config
     * @return FederatedSearchClient
     */
    public static function instance(string $baseUri, array $config = []): FederatedSearchClient
    {
        if (!self::$instance) {
            self::$instance = new self($baseUri, $config);
        }

        return self::$instance;
    }

    /**
     * @param $baseUri
     * @param array $config
     * @return HttpClient
     */
    public function configureClient($baseUri, array $config = []): HttpClient
    {
        $httpClient = new HttpClient([
            'base_uri' => $this->prepareBaserUri($baseUri),
            'headers' => [
                'Authorization' => 'Bearer ' . $config['token'],
            ],
            'connect_timeout' => $config['connectTimeout'] ?? 30,
            'request_timeout' => $config['requestTimeout'] ?? 30,
        ]);

        return $httpClient;
    }

    /**
     * @return FederatedSearchService
     */
    public function federatedSearch(): FederatedSearchService
    {
        return $this->federatedSearchService;
    }

    /**
     * @param $baseUri
     * @return string
     */
    private function prepareBaserUri(string $baseUri): string
    {
        return rtrim($baseUri, '/') . '/';
    }
}
