<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Packet;
use GuzzleHttp\RequestOptions;

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
     * @param string $packetId
     * @param string $email
     * @return void
     */
    public function send(string $packetId, string $email): void
    {
        $url = $this->resolveEndpoint("/slates/{$this->slateId}/packets/{$packetId}/send");

        $payload = [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'email' => $email,
                ],
            ],
        ];
        $this->httpClient->patch($url, [
            RequestOptions::JSON => $payload,
        ]);
    }

    /**
     * @param string $packetId
     * @param string $email
     * @return void
     */
    public function revokeSendAccess(string $packetId, string $email): void
    {
        $url = $this->resolveEndpoint("/slates/{$this->slateId}/packets/{$packetId}/send");

        $payload = [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'email' => $email,
                ],
            ],
        ];
        $this->httpClient->delete($url, [
            RequestOptions::JSON => $payload,
        ]);
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
