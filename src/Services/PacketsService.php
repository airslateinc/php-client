<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Packet;

/**
 * Class PacketsService
 * @package AirSlate\ApiClient\Services
 */
class PacketsService extends AbstractService
{
    protected $slateId;

    /**
     * @return Packet[]
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/slates/' . $this->slateId . '/packets');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Packet::createFromCollection($content);
    }

    /**
     * @param string $templateId
     * @return Packet
     * @throws \Exception
     */
    public function get(string $templateId): Packet
    {
        $url = $this->resolveEndpoint('/slates/' . $this->slateId . '/packets/' . $templateId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Packet::createFromOne($content);
    }

    /**
     * @return mixed
     */
    public function getSlateId()
    {
        return $this->slateId;
    }

    /**
     * @param string $slateId
     * @return PacketsService
     */
    public function setSlateId($slateId): PacketsService
    {
        $this->slateId = $slateId;

        return $this;
    }
}
