<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Packets\RevisionDocument;
use AirSlate\ApiClient\Entities\Packets\RevisionLinks;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;
use AirSlate\ApiClient\Models\Revision\Create;
use AirSlate\ApiClient\Models\RevisionDocument\BulkUpdate;
use AirSlate\ApiClient\Entities\Packets\Revision;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

class RevisionsService extends AbstractService
{
    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param string $revisionUid
     * @return RevisionLinks
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function links(string $flowUid, string $packetUid, string $revisionUid): RevisionLinks
    {
        $url = $this->resolveEndpoint("/slates/{$flowUid}/packets/{$packetUid}/revisions/{$revisionUid}/links");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return RevisionLinks::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param string $revisionUid
     * @return RevisionDocument[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function getDocuments(string $flowUid, string $packetUid, string $revisionUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/revisions/{$revisionUid}/documents");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return RevisionDocument::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param string $revisionUid
     * @param BulkUpdate $revisionDocuments
     * @return array
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function updateDocuments(
        string $flowUid,
        string $packetUid,
        string $revisionUid,
        BulkUpdate $revisionDocuments
    ): array {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/revisions/{$revisionUid}/documents");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $revisionDocuments->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return RevisionDocument::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @return Revision[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function collection(string $flowUid, string $packetUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/revisions");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Revision::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param string $revisionUid
     * @return Revision
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function get(string $flowUid, string $packetUid, string $revisionUid): Revision
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/revisions/{$revisionUid}");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Revision::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param Create $revision
     * @return Revision
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function create(string $flowUid, string $packetUid, Create $revision): Revision
    {
        $url = $this->resolveEndpoint('/flows/' . $flowUid . '/packets/' . $packetUid . '/revisions');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $revision->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Revision::createFromOne($content);
    }
}
