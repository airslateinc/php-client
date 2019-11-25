<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\DocumentRole;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Entities\Packet;
use AirSlate\ApiClient\Entities\Packets\PacketSend;
use AirSlate\ApiClient\Entities\Packets\PacketSigningOrder;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\Packets\UserHasNoAccessException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;
use AirSlate\ApiClient\Models\Packet\ActivateOpenAsRole;
use AirSlate\ApiClient\Models\Packet\Create;
use AirSlate\ApiClient\Models\Packet\Lock;
use AirSlate\ApiClient\Models\Packet\Send\Create as CreatePacketSend;
use AirSlate\ApiClient\Models\Packet\Send\Bulk as BulkPacketSend;
use AirSlate\ApiClient\Models\Packet\UnassignRole;
use AirSlate\ApiClient\Models\Packet\Update;
use AirSlate\ApiClient\Models\Packet\SigningOrder\Enable;
use Generator;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

/**
 * Class PacketsService
 * @package AirSlate\ApiClient\Services
 */
class PacketsService extends AbstractService
{
    /**
     * @return PacketRevisionsService
     */
    public function packetRevision(): PacketRevisionsService
    {
        return new PacketRevisionsService($this->httpClient);
    }

    /**
     * @return RevisionsService
     */
    public function revisions(): RevisionsService
    {
        return new RevisionsService($this->httpClient);
    }

    /**
     * @param string $flowUid
     * @return Packet[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function collection(string $flowUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Packet::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @return Generator
     */
    public function collectionIterator(string $flowUid): Generator
    {
        $page = 0;
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets");

        do {
            $page++;

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            yield from Packet::createFromCollection($content);
        } while ($content['meta']['current_page'] < $content['meta']['last_page']);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @return Packet
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function get(string $flowUid, string $packetUid): Packet
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Packet::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param Create $packet
     * @return Packet
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function create(string $flowUid, Create $packet): Packet
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $packet->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Packet::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @return Packet
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function finish(string $flowUid, string $packetUid): Packet
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/finish");

        $response = $this->httpClient->patch($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Packet::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param CreatePacketSend $packetSend
     * @return PacketSend[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function sendPacket(string $flowUid, string $packetUid, CreatePacketSend $packetSend): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/send");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $packetSend->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSend::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param BulkPacketSend $bulkPacketSend
     * @return PacketSend[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function sendPacketBulk(string $flowUid, string $packetUid, BulkPacketSend $bulkPacketSend): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/send/bulk");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $bulkPacketSend->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSend::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @return PacketSend[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function getPacketSend(string $flowUid, string $packetUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/send");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSend::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param string $email
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function revokeSendAccess(string $flowUid, string $packetUid, string $email): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/send");

        $payload = [
            'data' => [
                'type' => EntityType::USER,
                'attributes' => [
                    'email' => $email,
                ],
            ],
        ];

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $payload,
        ]);

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @return DocumentRole[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function getLatestRevisionRoles(string $flowUid, string $packetUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/latest-revision/roles");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentRole::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @return DocumentRole[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function getPacketRoles(string $flowUid, string $packetUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/roles");

        $response = $this->httpClient->get($url);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentRole::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @return PacketSigningOrder[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function getSigningOrders(string $flowUid, string $packetUid): array
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
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function bindRole(string $flowUid, string $packetUid, Enable $signingOrder): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/bind-user-to-role-on-init");

        $response = $this->httpClient->put($url, [
            RequestOptions::JSON => $signingOrder->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param ActivateOpenAsRole $activateOpenAsRole
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function activateOpenAsRole(string $flowUid, string $packetUid, ActivateOpenAsRole $activateOpenAsRole): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/activate-open-as-role");

        $response = $this->httpClient->put($url, [
            RequestOptions::JSON => $activateOpenAsRole->toArray(),
        ]);

        return $response && $response->getStatusCode() === 200;
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param UnassignRole $unassignRole
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function unassignRole(string $flowUid, string $packetUid, UnassignRole $unassignRole): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/unassign-role");

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $unassignRole->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param Enable $signingOrder
     * @return PacketSigningOrder[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
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
     * @param string $flowUid
     * @param string $packetUid
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function delete(string $flowUid, string $packetUid): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}");

        $response = $this->httpClient->delete($url);

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param Update $packet
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function update(string $flowUid, string $packetUid, Update $packet): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}");

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
     * @throws UserHasNoAccessException
     * @throws InvalidArgumentException
     * @throws DomainException
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
        } catch (DomainException $e) {
            throw new UserHasNoAccessException($e->getMessage(), $e->getCode(), $e);
        }

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param Lock $lock
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function lock(string $flowUid, string $packetUid, Lock $lock): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/lock");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $lock->toArray(),
        ]);

        return $response && $response->getStatusCode() === 200;
    }
}
