<?php
declare(strict_types=1);

namespace AirSlate\ApiClient;

use AirSlate\ApiClient\Http\Client as HttpClient;
use AirSlate\ApiClient\Services\AddonsService;
use AirSlate\ApiClient\Services\DocumentsService;
use AirSlate\ApiClient\Services\EventBusService;
use AirSlate\ApiClient\Services\ExportService;
use AirSlate\ApiClient\Services\FilesService;
use AirSlate\ApiClient\Services\PermissionsService;
use AirSlate\ApiClient\Services\RevisionsService;
use AirSlate\ApiClient\Services\SlatesService;
use AirSlate\ApiClient\Services\UsersService;
use AirSlate\ApiClient\Services\AddonsSmsService;
use AirSlate\ApiClient\Services\PacketRevisionsService;

/**
 * Class Client
 * @package AirSlate\ApiClient
 */
class Client
{
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
     * @var ExportService
     */
    private $exportService;
    /**
     * @var SlatesService
     */
    private $slatesService;
    /**
     * @var AddonsService
     */
    private $addonsService;
    /**
     * @var EventBusService
     */
    private $eventBusService;
    /**
     * @var PermissionsService
     */
    private $permissionsService;
    /**
     * @var RevisionsService
     */
    private $revisionsService;
    /**
     * @var AddonsSmsService
     */
    private $addonsSmsService;
    /**
     * @var PacketRevisionsService
     */
    private $packetRevisionsService;

    /**
     * Client instances.
     * @var Client[]
     */
    private static $instances;

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
            'headers' => $this->prepareHeaders($config),
            'connect_timeout' => $config['connectTimeout'] ?? 30,
            'request_timeout' => $config['requestTimeout'] ?? 30,
            'handler' => $config['handler'] ?? null
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

        self::$instances[$hash] = self::$instances[$hash] ?? null;

        if (!self::$instances[$hash]) {
            self::$instances[$hash] = new self($baseUri, $config);
        }

        return self::$instances[$hash];
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
     * @return ExportService
     */
    public function export(): ExportService
    {
        if (!$this->exportService) {
            $this->exportService = new ExportService($this->httpClient);
        }

        return $this->exportService;
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

    /**
     * @return AddonsService
     */
    public function addons(): AddonsService
    {
        if (!$this->addonsService) {
            $this->addonsService = new AddonsService($this->httpClient);
        }

        return $this->addonsService;
    }

    /**
     * @deprecated This service is going to be moved to separate client
     * @return EventBusService
     */
    public function eventBus(): EventBusService
    {
        if (!$this->eventBusService) {
            $this->eventBusService = new EventBusService($this->httpClient);
        }

        return $this->eventBusService;
    }

    /**
     * @return PermissionsService
     */
    public function permissions(): PermissionsService
    {
        if (!$this->permissionsService) {
            $this->permissionsService = new PermissionsService($this->httpClient);
        }

        return $this->permissionsService;
    }

    public function revisions(): RevisionsService
    {
        if (!$this->revisionsService) {
            $this->revisionsService = new RevisionsService($this->httpClient);
        }

        return $this->revisionsService;
    }

    /**
     * @return AddonsSmsService
     */
    public function addonsSms(): AddonsSmsService
    {
        if (!$this->addonsSmsService) {
            $this->addonsSmsService = new AddonsSmsService($this->httpClient);
        }

        return $this->addonsSmsService;
    }

    /**
     * @return PacketRevisionsService
     */
    public function packetRevisions(): PacketRevisionsService
    {
        if (!$this->packetRevisionsService) {
            $this->packetRevisionsService = new PacketRevisionsService($this->httpClient);
        }

        return $this->packetRevisionsService;
    }
}
