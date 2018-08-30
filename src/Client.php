<?php
declare(strict_types=1);

namespace AirSlate\ApiClient;

use AirSlate\ApiClient\Http\Client as HttpClient;
use AirSlate\ApiClient\Services\AddonsService;
use AirSlate\ApiClient\Services\DocumentsService;
use AirSlate\ApiClient\Services\ExportService;
use AirSlate\ApiClient\Services\FilesService;
use AirSlate\ApiClient\Services\IntegrationsService;
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
    private $exportService;
    private $slatesService;
    private $addonsService;
    private $integrationsService;

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
        $this->exportService = new ExportService($httpClient);
        $this->slatesService = new SlatesService($httpClient);
        $this->addonsService = new AddonsService($httpClient);
        $this->integrationsService = new IntegrationsService($httpClient);
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
            'headers' => $this->prepareHeaders($config),
            'connect_timeout' => $config['connectTimeout'] ?? 30,
            'request_timeout' => $config['requestTimeout'] ?? 30,
        ]);

        return $httpClient;
    }

    /**
     * @param array $config
     * @return array
     */
    private function getDefaultHeaders(array $config): array
    {
        return [
            'Authorization' => 'Bearer ' . ($config['token'] ?? ''),
            'X-Request-Id' => $config['requestId'] ?? ''
        ];
    }

    /**
     * @param array $config
     * @return array
     */
    private function prepareHeaders(array $config): array
    {
        return array_merge(
            $this->getDefaultHeaders($config),
            $config['headers'] ?? []
        );
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

        self::$instance[$hash] = self::$instance[$hash] ?? null;

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
     * @return ExportService
     */
    public function export(): ExportService
    {
        return $this->exportService;
    }

    /**
     * @return SlatesService
     */
    public function slates(): SlatesService
    {
        return $this->slatesService;
    }

    /**
     * @return AddonsService
     */
    public function addons(): AddonsService
    {
        return $this->addonsService;
    }

    /**
     * @return IntegrationsService
     */
    public function integrations(): IntegrationsService
    {
        return $this->integrationsService;
    }
}
