<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services\CloudStorage;

use AirSlate\ApiClient\Entities\CloudStorage\DataProvideResponse;
use AirSlate\ApiClient\Entities\CloudStorage\DataStorage;
use AirSlate\ApiClient\Entities\CloudStorage\Watch;
use AirSlate\ApiClient\Models\CloudStorage\Create;
use AirSlate\ApiClient\Models\CloudStorage\Provide;
use AirSlate\ApiClient\Models\CloudStorage\StructureUpdate;
use AirSlate\ApiClient\Models\CloudStorage\Subscribe;
use AirSlate\ApiClient\Models\CloudStorage\UpdateOrCreate;
use AirSlate\ApiClient\Models\CloudStorage\Watch as WatchRequest;
use AirSlate\ApiClient\Services\AbstractService;
use GuzzleHttp\RequestOptions;

class CloudStorageService extends AbstractService
{
    /**
     * @return ConnectionsService
     */
    public function connections(): ConnectionsService
    {
        return new ConnectionsService($this->httpClient);
    }

    /**
     * @param Subscribe $subscribe
     * @return bool
     */
    public function subscribe(Subscribe $subscribe): DataStorage
    {
        $url = $this->resolveEndpoint('/cloud-storage/subscribe');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $subscribe->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DataStorage::createFromOne($content);
    }

    /**
     * @param Provide $provide
     * @return DataProvideResponse
     */
    public function provide(Provide $provide): DataProvideResponse
    {
        $url = $this->resolveEndpoint('/cloud-storage/provide');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $provide->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DataProvideResponse::createFromOne($content);
    }

    /**
     * @param Create $create
     * @return bool
     */
    public function create(Create $create): bool
    {
        $url = $this->resolveEndpoint('/cloud-storage/create');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $create->toArray(),
        ]);

        return $response && $response->getStatusCode() === 200;
    }

    /**
     * @param UpdateOrCreate $updateOrCreate
     * @return bool
     */
    public function updateOrCreate(UpdateOrCreate $updateOrCreate): bool
    {
        $url = $this->resolveEndpoint('/cloud-storage/updateOrCreate');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $updateOrCreate->toArray(),
        ]);

        return $response && $response->getStatusCode() === 200;
    }

    /**
     * @param StructureUpdate $structureUpdate
     * @return DataStorage
     */
    public function updateStructure(StructureUpdate $structureUpdate): DataStorage
    {
        $url = $this->resolveEndpoint('/cloud-storage/structure-update');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $structureUpdate->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DataStorage::createFromOne($content);
    }

    /**
     * @param WatchRequest $watch
     * @return Watch
     */
    public function watch(WatchRequest $watch): Watch
    {
        $url = $this->resolveEndpoint('/cloud-storage/watch');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $watch->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Watch::createFromOne($content);
    }
}
