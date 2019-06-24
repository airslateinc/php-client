<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\PacketRevision;

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
     * @param string $slateId
     * @param string $packetId
     * @param string $revisionId
     * @return PacketRevision
     * @throws \Exception
     */
    public function oneBySlateIdAndRevisionId(string $slateId, string $packetId, string $revisionId): PacketRevision
    {
        $url = $this->resolveEndpoint('flows/' . $slateId . '/packets/' . $packetId . '/revisions/' . $revisionId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketRevision::createFromOne($content);
    }
}
