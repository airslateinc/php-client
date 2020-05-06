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
     * @param string $flowUid
     * @param string $packetUid
     * @param string $revisionUid
     * @return PacketRevision
     */
    public function oneBySlateIdAndRevisionId(string $flowUid, string $packetUid, string $revisionUid): PacketRevision
    {
        $url = $this->resolveEndpoint("flows/{$flowUid}/packets/{$packetUid}/revisions/{$revisionUid}");

        $response = $this->httpClient->get($url, [
            RequestOptions::QUERY  => [
                'include' => 'documents'
            ]
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketRevision::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param string $revisionUid
     * @param Update $revisionUpdate
     * @return PacketRevision
     */
    public function update(
        string $flowUid,
        string $packetUid,
        string $revisionUid,
        Update $revisionUpdate
    ): PacketRevision {
        $url = $this->resolveEndpoint("flows/{$flowUid}/packets/{$packetUid}/revisions/{$revisionUid}");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $revisionUpdate->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketRevision::createFromOne($content);
    }
}
