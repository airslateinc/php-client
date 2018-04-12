<?php

namespace AirSlate\ApiClient;

use AirSlate\ApiClient\Http\Client as HttpClient;
use AirSlate\ApiClient\Services\UsersService;

/**
 * Class Client
 * @package AirSlate\UsersManagement
 */
class Client
{
    /**
     *
     */
    const LATEST_API_VERSION = 1;

    /**
     * Client instances.
     * @var Client
     */
    static private $instance;
    /**
     * @var UsersService
     */
    private $usersService;

    /**
     * Client constructor.
     * @param string $baseUri
     * @param array $config
     */
    private function __construct(string $baseUri, $config = [])
    {
        $httpClient = new HttpClient([
            'base_uri' => $baseUri,
            'headers' => [
                'Authorization' => 'Bearer ' . $config['token']
            ]
        ]);

        $this->usersService = new UsersService($httpClient);
    }

    /**
     * @param string $baseUri
     * @param array $config
     * @return Client
     */
    public static function instance(string $baseUri, array $config = []): Client
    {
        if (!self::$instance) {
            self::$instance = new self($baseUri, $config);
        }

        return self::$instance;
    }

    /**
     * @return UsersService
     */
    public function users(): UsersService
    {
        return $this->usersService;
    }
}
