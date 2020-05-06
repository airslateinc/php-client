<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\Revision\Update;
use Generator;
use AirSlate\ApiClient\Entities\PacketRevision;
use GuzzleHttp\RequestOptions;

/**
 * Class PacketRevisionsService
 * @package AirSlate\ApiClient\Services
 */
class PacketRevisionsService extends AbstractService
{
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/packet-revisions');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketRevision::createFromCollection($content);
    }

    /**
     * @return Generator|PacketRevision[]
     */
    public function collectionIterator(): Generator
    {
        $url = $this->resolveEndpoint('/packet-revisions');
        yield from $this->pagination()->resolve($url, PacketRevision::class);
    }

    /**
     * @param string $slateId
     * @param string $packetId
     * @param string $revisionId
     * @return PacketRevision
     * @throws \Exception
     */
    public function oneBySlateIdAndRevisionId(string $slateId, string $packetId, string $revisionId): PacketRevision
    {
        $url = $this->resolveEndpoint('flows/' . $slateId . '/packets/' . $packetId . '/revisions/' . $revisionId);

        $response = $this->httpClient->get($url, [
            RequestOptions::QUERY  => [
                'include' => 'documents'
            ]
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketRevision::createFromOne($content);
    }

    /**
     * @param string $slateId
     * @param string $packetId
     * @param string $revisionId
     * @param Update $revisionUpdate
     * @return PacketRevision
     */
    public function update(
        string $slateId,
        string $packetId,
        string $revisionId,
        Update $revisionUpdate
    ): PacketRevision {
        $url = $this->resolveEndpoint('flows/' . $slateId . '/packets/' . $packetId . '/revisions/' . $revisionId);

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $revisionUpdate->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketRevision::createFromOne($content);
    }
}
