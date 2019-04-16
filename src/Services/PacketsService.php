<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\DocumentRole;
use AirSlate\ApiClient\Entities\Packet;
use AirSlate\ApiClient\Entities\Packets\PacketSend;
use AirSlate\ApiClient\Entities\PacketSigningOrder;
use AirSlate\ApiClient\Models\Packet\Create;
use AirSlate\ApiClient\Models\Packet\Send\Create as CreatePacketSend;
use AirSlate\ApiClient\Models\Packet\Update;
use AirSlate\ApiClient\Models\Packet\SigningOrder\Enable;
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
     * @param Create $packet
     * @return Packet
     * @throws \Exception
     */
    public function create(Create $packet): Packet
    {
        $url = $this->resolveEndpoint('/flows/' . $this->slateId . '/packets');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $packet->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Packet::createFromOne($content);
    }

    /**
     * @param Packet $packet
     * @return Packet
     * @throws \Exception
     */
    public function finish(Packet $packet): Packet
    {
        $url = $this->resolveEndpoint('/flows/' . $this->slateId . '/packets/' . $packet->id . '/finish');

        $response = $this->httpClient->patch($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Packet::createFromOne($content);
    }

    /**
     * @deprecated
     * use \AirSlate\ApiClient\Services\PacketsService::sendPacket instead of this method
     *
     * @TODO: default access level is set to WRITE to prevent backward incompatibility
     *
     * @param string $packetId
     * @param string $email
     * @param string $accessLevel
     *
     * @return void
     */
    public function send(string $packetId, string $email, string $accessLevel = PacketSend::ACCESS_LEVEL_WRITE): void
    {
        $url = $this->resolveEndpoint("/slates/{$this->slateId}/packets/{$packetId}/send");

        $payload = [
            'data' => [
                'type' => 'packet_send',
                'attributes' => [
                    'email' => $email,
                    'access_level' => $accessLevel,
                ],
            ],
        ];
        $this->httpClient->post($url, [
            RequestOptions::JSON => $payload,
        ]);
    }

    /**
     * @param string           $packetId
     * @param CreatePacketSend $packetSend
     *
     * @return PacketSend
     *
     * @throws \Exception
     */
    public function sendPacket(string $packetId, CreatePacketSend $packetSend): PacketSend
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/packets/{$packetId}/send");

        $payload = [
            'data' => $packetSend->toArray(),
        ];

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $payload,
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSend::createFromOne($content);
    }

    /**
     * @param string                   $packetId
     * @param array|CreatePacketSend[] $packetSends
     *
     * @return array|PacketSend[]
     *
     * @throws \Exception
     */
    public function sendPacketBulk(string $packetId, array $packetSends): array
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/packets/{$packetId}/send/bulk");

        $payload = [
            'data' => [],
        ];

        foreach ($packetSends as $packetSend) {
            $payload['data'][] = $packetSend->toArray();
        }

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $payload,
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSend::createFromCollection($content);
    }

    /**
     * @param string $packetId
     * @return PacketSend[]
     * @throws \Exception
     */
    public function getPacketSend(string $packetId): array
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/packets/{$packetId}/send");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSend::createFromCollection($content);
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
     * @param string $flowUid
     * @param string $packetUid
     * @return DocumentRole[]
     * @throws \Exception
     */
    public function getRoles(string $flowUid, string $packetUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/latest-revision/roles");

        $response = $this->httpClient->get($url);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentRole::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param Enable $signingOrder
     * @return PacketSigningOrder
     * @throws \Exception
     */
    public function updateSigningOrder(string $flowUid, string $packetUid, Enable $signingOrder): PacketSigningOrder
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/signing-order");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $signingOrder->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSigningOrder::createFromOne($content);
    }

    /**
     * @param string $packetId
     * @return RevisionsService
     */
    public function revisions(string $packetId): RevisionsService
    {
        return (new RevisionsService($this->httpClient))->setSlateId($this->slateId)->setPacketId($packetId);
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

    /**
     * @param string $packetId
     * @return bool
     */
    public function delete(string $packetId): bool
    {
        $url = $this->resolveEndpoint("/slates/{$this->slateId}/packets/{$packetId}");

        $response = $this->httpClient->delete($url);

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param string $packetId
     * @param Update $packet
     * @return bool
     * @throws \Exception
     */
    public function update(string $packetId, Update $packet): bool
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/packets/{$packetId}");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $packet->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}
