<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\CloudStorage\DataProvideResponse;
use AirSlate\ApiClient\Entities\CloudStorage\DataStorage;
use AirSlate\ApiClient\Models\CloudStorage\Provide;
use AirSlate\ApiClient\Models\CloudStorage\StructureUpdate;
use AirSlate\ApiClient\Models\CloudStorage\Subscribe;
use AirSlate\ApiClient\Models\CloudStorage\Update;
use GuzzleHttp\RequestOptions;

class CloudStorageService extends AbstractService
{
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
     * @param Update $update
     * @return bool
     */
    public function update(Update $update): bool
    {
        $url = $this->resolveEndpoint('/cloud-storage/update');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $update->toArray(),
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
}
