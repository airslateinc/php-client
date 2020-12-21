<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services\CloudStorage;

use AirSlate\ApiClient\Entities\CloudStorage\Connection;
use AirSlate\ApiClient\Models\CloudStorage\Connection\Delete;
use AirSlate\ApiClient\Models\CloudStorage\Connection\Update;
use AirSlate\ApiClient\Services\AbstractService;
use GuzzleHttp\RequestOptions;

class ConnectionsService extends AbstractService
{
    /**
     * @param Update $update
     * @return Connection
     */
    public function update(Update $update): Connection
    {
        $url = $this->resolveEndpoint('/cloud-storage/connection/update');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $update->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Connection::createFromOne($content);
    }

    /**
     * @param Delete $delete
     * @return bool
     */
    public function delete(Delete $delete): bool
    {
        $url = $this->resolveEndpoint('/cloud-storage/connection/delete');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $delete->toArray(),
        ]);

        return $response && $response->getStatusCode() === 200;
    }
}
