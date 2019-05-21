<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\DocumentRole;
use AirSlate\ApiClient\Entities\Packet;
use AirSlate\ApiClient\Entities\Packets\PacketSend;
use AirSlate\ApiClient\Entities\Packets\PacketSigningOrder;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Exceptions\Packets\NoSuchUserException;
use AirSlate\ApiClient\Exceptions\Packets\UserHasNoAccessException;
use AirSlate\ApiClient\Models\Packet\Create;
use AirSlate\ApiClient\Models\Packet\Send\Create as CreatePacketSend;
use AirSlate\ApiClient\Models\Packet\Send\Bulk as BulkPacketSend;
use AirSlate\ApiClient\Models\Packet\Update;
use AirSlate\ApiClient\Models\Packet\SigningOrder\Enable;
use GuzzleHttp\Exception\BadResponseException;
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

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $packetSend->toArray(),
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSend::createFromOne($content);
    }

    /**
     * @param string $packetId
     * @param BulkPacketSend $bulkPacketSend
     * @return array|PacketSend[]
     *
     * @throws \Exception
     */
    public function sendPacketBulk(string $packetId, BulkPacketSend $bulkPacketSend): array
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/packets/{$packetId}/send/bulk");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $bulkPacketSend->toArray(),
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
     * @return array
     * @throws \Exception
     */
    public function getSigningOrders(string $flowUid, string $packetUid)
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/signing-order");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSigningOrder::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param Enable $signingOrder
     * @return array
     * @throws \Exception
     */
    public function updateSigningOrder(string $flowUid, string $packetUid, Enable $signingOrder): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/signing-order");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $signingOrder->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSigningOrder::createFromCollection($content);
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


    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param string $revisionUid
     * @param string $email
     * @return bool
     * @throws NoSuchUserException
     * @throws UserHasNoAccessException
     * @throws \Exception
     */
    public function checkAccess(string $flowUid, string $packetUid, string $revisionUid, string $email): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/revisions/{$revisionUid}/access");

        try {
            $response = $this->httpClient->get($url, [
                RequestOptions::QUERY => [
                    'filter' => [
                        'email' => $email
                    ],
                ],
            ]);
        } catch (BadResponseException $e) {
            throw new NoSuchUserException($e->getMessage(), $e->getCode(), $e);
        } catch (DomainException $e) {
            throw new UserHasNoAccessException($e->getMessage(), $e->getCode(), $e);
        }

        return $response && $response->getStatusCode() === 204;
    }
}
