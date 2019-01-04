<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Packets\RevisionLinks;
use AirSlate\ApiClient\Entities\Packets\Revision;

class RevisionsService extends AbstractService
{
    /** @var string */
    private $slateId;

    /** @var string */
    private $packetId;

    /**
     * @param $revisionId
     * @return RevisionLinks
     * @throws \Exception
     */
    public function links($revisionId): RevisionLinks
    {
        $url = $this->resolveEndpoint(
            '/slates/' . $this->slateId . '/packets/' . $this->packetId . '/revisions/' . $revisionId . '/links'
        );

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return RevisionLinks::createFromOne($content);
    }

    /**
     * @param string $slateId
     *
     * @return RevisionsService
     */
    public function setSlateId($slateId): RevisionsService
    {
        $this->slateId = $slateId;

        return $this;
    }

    /**
     * @param string $packetId
     *
     * @return RevisionsService
     */
    public function setPacketId($packetId): RevisionsService
    {
        $this->packetId = $packetId;

        return $this;
    }

    /**
     * @return Revision[]
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/flows/' . $this->slateId . '/packets/' . $this->packetId . '/revisions');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Revision::createFromCollection($content);
    }
}
