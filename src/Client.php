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
     * @var HttpClient
     */
    private $httpClient;
    /**
     * @var UsersService
     */
    private $usersService;
    /**
     * @var DocumentsService
     */
    private $documentsService;
    /**
     * @var FilesService
     */
    private $filesService;
    /**
     * @var SlatesService
     */
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
        $this->httpClient = $this->configureClient($baseUri, $config);
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
        if (!$this->usersService) {
            $this->usersService = new UsersService($this->httpClient);
        }

        return $this->usersService;
    }

    /**
     * @return DocumentsService
     */
    public function documents(): DocumentsService
    {
        if (!$this->documentsService) {
            $this->documentsService = new DocumentsService($this->httpClient);
        }

        return $this->documentsService;
    }

    /**
     * @return FilesService
     */
    public function files(): FilesService
    {
        if (!$this->filesService) {
            $this->filesService = new FilesService($this->httpClient);
        }

        return $this->filesService;
    }

    /**
     * @return SlatesService
     */
    public function slates(): SlatesService
    {
        if (!$this->slatesService) {
            $this->slatesService = new SlatesService($this->httpClient);
        }

        return $this->slatesService;
    }
}
