<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Document as DocumentEntity;
use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Models\Document\Create as CreateModel;
use AirSlate\ApiClient\Models\Document\Duplicate as DuplicateModel;
use AirSlate\ApiClient\Models\Document\Export as ExportModel;
use AirSlate\ApiClient\Models\Document\Upload as UploadModel;
use GuzzleHttp\RequestOptions;

/**
 * Class DocumentsService
 * @package AirSlate\UsersManagement\Services
 */
class DocumentsService extends AbstractService
{
    /**
     * Create document
     *
     * @param CreateModel $document
     * @return DocumentEntity
     * @throws \Exception
     */
    public function create(CreateModel $document)
    {
        $url = $this->resolveEndpoint('/documents');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $document->toArray(),
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);
        return DocumentEntity::createFromOne($content);
    }

    /**
     * Duplicate documents
     *
     * @param DuplicateModel $document
     * @return DocumentEntity[]
     * @throws \Exception
     */
    public function duplicate(DuplicateModel $document): array
    {
        $url = $this->resolveEndpoint('/documents/duplicate');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $document->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentEntity::createFromCollection($content);
    }

    /**
     * Document get
     *
     * @param string $documentId
     * @return Document
     * @throws \Exception
     */
    public function get(string $documentId): Document
    {
        $url = $this->resolveEndpoint('/documents/' . $documentId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromOne($content);
    }

    /**
     * @param array $filter
     * @param array $options
     * @return Document[]
     * @throws \Exception
     */
    public function collection($filter = [], array $options = []): array
    {
        $url = $this->resolveEndpoint('/documents');
        if (!empty($options)) {
            $url .= '?' . http_build_query(['filter' => $filter]);
        }
        if (!empty($options)) {
            $url .= '&' . http_build_query($options);
        }

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromCollection($content);
    }

    /**
     * Export documents
     *
     * @param ExportModel $document
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function export(ExportModel $document): array
    {
        $url = $this->resolveEndpoint('/export/bulk');

        try {
            $response = $this->httpClient->post($url, [
                RequestOptions::JSON => $document->toArray(),
            ]);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);
        } catch (DomainException $e) {
            $content = \GuzzleHttp\json_decode($e->getMessage(), true);
        }

        return $content;
    }

    /**
     * Check the export status
     *
     * @param string $exportId
     *
     * @return array
     */
    public function exportStatus(string $exportId): array
    {
        $url = $this->resolveEndpoint("/export/$exportId/status");

        try {
            $response = $this->httpClient->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);
        } catch (DomainException $e) {
            $content = \GuzzleHttp\json_decode($e->getMessage(), true);
        }

        return $content;
    }

    /**
     * Upload document
     *
     * @param UploadModel $upload
     * @return mixed
     */
    public function upload(UploadModel $upload)
    {
        $url = $this->resolveEndpoint('/documents/upload');

        try {
            $response = $this->httpClient->post($url, [
                RequestOptions::JSON => $upload->toArray(),
            ]);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);
        } catch (DomainException $e) {
            $content = \GuzzleHttp\json_decode($e->getMessage(), true);
        }

        return $content;
    }
}
