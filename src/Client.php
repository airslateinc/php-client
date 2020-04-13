<?php
declare(strict_types=1);

namespace AirSlate\ApiClient;

use AirSlate\ApiClient\Http\Client as HttpClient;
use AirSlate\ApiClient\Services\AddonFlowDocumentsService;
use AirSlate\ApiClient\Services\AddonLogsService;
use AirSlate\ApiClient\Services\AddonsService;
use AirSlate\ApiClient\Services\AddonsSmsService;
use AirSlate\ApiClient\Services\DocumentsService;
use AirSlate\ApiClient\Services\ExportService;
use AirSlate\ApiClient\Services\FilesService;
use AirSlate\ApiClient\Services\FlowsService;
use AirSlate\ApiClient\Services\PacketRevisionsService;
use AirSlate\ApiClient\Services\PermissionsService;
use AirSlate\ApiClient\Services\RevisionsService;
use AirSlate\ApiClient\Services\UsersService;

/**
 * Class Client
 * @package AirSlate\ApiClient
 */
class Client
{
    private const CONTENT_TYPE_JSON_API = 'application/vnd.api+json';
    private const CONTENT_TYPE_JSON = 'application/json';

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
     * @var FlowsService
     */
    private $flowsService;
    /**
     * @var AddonsService
     */
    private $addonsService;
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
     * @var AddonLogsService
     */
    private $addonLogsService;

    /**
     * @var AddonFlowDocumentsService
     */
    private $addonFlowDocumentsService;

    /**
     * Client instances.
     * @var Client[]
     */
    private static $instances;

    /**
     * Client ID
     * @var string|null
     */
    private $clientId = '';

    /**
     * Client Secret
     * @var string|null
     */
    private $clientSecret = '';

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
        $this->clientId = $config['client_id'] ?? null;
        $this->clientSecret = $config['client_secret'] ?? null;

        $httpClient = new HttpClient([
            'base_uri' => $this->prepareBaserUri($baseUri),
            'headers' => $this->prepareHeaders($config),
            'connect_timeout' => $config['connectTimeout'] ?? 30,
            'timeout' => $config['requestTimeout'] ?? 30,
            'handler' => $config['handler'] ?? null,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
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
            'X-Request-Id' => $config['requestId'] ?? '',
            // json:api specific headers
            'Content-Type' => self::CONTENT_TYPE_JSON_API,
            'Accept' => self::CONTENT_TYPE_JSON . ', ' . self::CONTENT_TYPE_JSON_API,
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
     * @return FlowsService
     */
    public function flows(): FlowsService
    {
        if (!$this->flowsService) {
            $this->flowsService = new FlowsService($this->httpClient);
        }

        return $this->flowsService;
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

    /**
     * @return AddonLogsService
     */
    public function addonLogs(): AddonLogsService
    {
        if (!$this->addonLogsService) {
            $this->addonLogsService = new AddonLogsService($this->httpClient);
        }

        return $this->addonLogsService;
    }

    /**
     * @return AddonFlowDocumentsService
     */
    public function addonFlowDocuments(): AddonFlowDocumentsService
    {
        if (!$this->addonFlowDocumentsService) {
            $this->addonFlowDocumentsService = new AddonFlowDocumentsService($this->httpClient);
        }

        return $this->addonFlowDocumentsService;
    }
}
