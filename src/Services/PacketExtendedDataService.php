<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Packets\PacketExtendedData;
use AirSlate\ApiClient\Models\Packet\ExtendedData\Create;
use AirSlate\ApiClient\Models\Packet\ExtendedData\Delete;
use AirSlate\ApiClient\Models\Packet\ExtendedData\Update;
use GuzzleHttp\RequestOptions;

class PacketExtendedDataService extends AbstractService
{
    /**
     * @return PacketExtendedData[]
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint("/packets/extended-data");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketExtendedData::createFromCollection($content);
    }

    /**
     * @param string $flowId
     * @param string $packetId
     * @param Create $model
     * @return PacketExtendedData
     */
    public function create(string $flowId, string $packetId, Create $model): PacketExtendedData
    {
        $url = $this->resolveEndpoint("flows/{$flowId}/packets/{$packetId}/extended-data");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $model->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketExtendedData::createFromOne($content);
    }

    /**
     * @param string $flowId
     * @param string $packetId
     * @param Update $model
     * @return PacketExtendedData
     */
    public function update(string $flowId, string $packetId, Update $model): PacketExtendedData
    {
        $url = $this->resolveEndpoint("flows/{$flowId}/packets/{$packetId}/extended-data");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $model->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketExtendedData::createFromOne($content);
    }

    /**
     * @param string $flowId
     * @param string $packetId
     * @param Delete $model
     * @return bool
     */
    public function delete(string $flowId, string $packetId, Delete $model): bool
    {
        $url = $this->resolveEndpoint("flows/{$flowId}/packets/{$packetId}/extended-data");

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $model->toArray()
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}
