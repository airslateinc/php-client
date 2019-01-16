<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Packets\RevisionDocument;
use AirSlate\ApiClient\Entities\Packets\RevisionLinks;
use AirSlate\ApiClient\Models\RevisionDocument\BulkUpdate;
use GuzzleHttp\RequestOptions;

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

    public function getDocuments(string $revisionId)
    {
        $url = $this->resolveEndpoint(
            '/flows/' . $this->slateId . '/packets/' . $this->packetId . '/revisions/' . $revisionId . '/documents'
        );

        $response = $this->httpClient->get($url);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return RevisionDocument::createFromCollection($content);
    }

    public function updateDocuments(string $revisionId, BulkUpdate $revisionDocuments)
    {
        $url = $this->resolveEndpoint(
            '/flows/' . $this->slateId . '/packets/' . $this->packetId . '/revisions/' . $revisionId . '/documents'
        );

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $revisionDocuments->toArray(),
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return RevisionDocument::createFromCollection($content);
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
}
