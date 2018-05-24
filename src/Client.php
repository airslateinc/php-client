<?php
declare(strict_types=1);

namespace AirSlate\ApiClient;

use AirSlate\ApiClient\Http\Client as HttpClient;
use AirSlate\ApiClient\Services\DocumentsService;
use AirSlate\ApiClient\Services\FilesService;
use AirSlate\ApiClient\Services\SlatesService;
use AirSlate\ApiClient\Services\UsersService;

/**
 * Class Client
 * @package AirSlate\ApiClient
 */
class Client
{
    /**
     * Client instances.
     * @var Client
     */
    static private $instance;
    /**
     * @var UsersService
     */
    private $usersService;
    private $documentsService;
    private $filesService;
    private $slatesService;

    /**
     * Client constructor.
     * @param string $baseUri
     * @param array $config
     * config['token'] = '';
     * config['requestId'] = '';
     * config['connectTimeout'] = 30; //default
     * config['requestTimeout'] = 30; //default
     */
    private function __construct(string $baseUri, array $config = [])
    {
        $httpClient = $this->configureClient($baseUri, $config);

        $this->usersService = new UsersService($httpClient);
        $this->documentsService = new DocumentsService($httpClient);
        $this->filesService = new FilesService($httpClient);
        $this->slatesService = new SlatesService($httpClient);
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
                'X-Request-Id' => $config['requestId'],
            ],
            'connect_timeout' => $config['connectTimeout'] ?? 30,
            'request_timeout' => $config['requestTimeout'] ?? 30,
        ]);

        return $httpClient;
    }

    /**
     * @param $baseUri
     * @return string
     */
    private function prepareBaserUri(string $baseUri): string
    {
        return rtrim($baseUri, '/') . '/';
    }

    /**
     * @param string $baseUri
     * @param array $config
     * @return Client
     */
    public static function instance(string $baseUri, array $config = []): Client
    {
        $hash = md5($baseUri . ':' . json_encode($config));

        if (!self::$instance[$hash]) {
            self::$instance[$hash] = new self($baseUri, $config);
        }

        return self::$instance[$hash];
    }

    /**
     * @return UsersService
     */
    public function users(): UsersService
    {
        return $this->usersService;
    }

    /**
     * @return DocumentsService
     */
    public function documents(): DocumentsService
    {
        return $this->documentsService;
    }

    /**
     * @return FilesService
     */
    public function files(): FilesService
    {
        return $this->filesService;
    }

    /**
     * @return SlatesService
     */
    public function slates(): SlatesService
    {
        return $this->slatesService;
    }
}
