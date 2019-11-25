<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

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
     * @return Generator
     */
    public function collectionIterator(): Generator
    {
        $page = 0;
        $url = $this->resolveEndpoint('/packet-revisions');

        do {
            $page++;

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            yield from PacketRevision::createFromCollection($content);
        } while ($content['meta']['current_page'] < $content['meta']['last_page']);
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
}
