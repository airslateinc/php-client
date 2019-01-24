<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\DocumentAttachment;
use AirSlate\ApiClient\Entities\Field;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Models\Document\AddAttachments;
use AirSlate\ApiClient\Models\Document\AddDocumentAttachments;
use AirSlate\ApiClient\Models\Document\Create as CreateModel;
use AirSlate\ApiClient\Models\Document\Update as UpdateModel;
use AirSlate\ApiClient\Models\Document\Duplicate as DuplicateModel;
use AirSlate\ApiClient\Models\Document\Export as ExportModel;
use AirSlate\ApiClient\Models\Document\UpdateFields;
use AirSlate\ApiClient\Models\Document\Upload as UploadModel;
use GuzzleHttp\RequestOptions;

/**
 * Class DocumentsService
 * @package AirSlate\ApiClient\Services
 */
class DocumentsService extends AbstractService
{
    /**
     * Create document
     *
     * @param CreateModel $document
     * @return Document
     * @throws \Exception
     */
    public function create(CreateModel $document): Document
    {
        $url = $this->resolveEndpoint('/documents');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $document->toArray(),
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromOne($content);
    }

    /**
     * Update document
     *
     * @param UpdateModel $document
     * @return Document
     * @throws \Exception
     */
    public function update(UpdateModel $document) : Document
    {
        $url = $this->resolveEndpoint("/documents/$document->id");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $document->toArray(),
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);
        return Document::createFromOne($content);
    }

    /**
     * Duplicate documents
     *
     * @param DuplicateModel $document
     * @return Document[]|array
     * @throws \Exception
     */
    public function duplicate(DuplicateModel $document): array
    {
        $url = $this->resolveEndpoint('/documents/duplicate');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $document->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromCollection($content);
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
        return $this->getDocuments($url, $filter, $options);
    }

    /**
     * Get documents collection with content
     * @param array $filter
     * @param array $options
     * @return Document[]
     * @throws \Exception
     */
    public function content($filter = [], array $options = []): array
    {
        $url = $this->resolveEndpoint('/documents/content');
        return $this->getDocuments($url, $filter, $options);
    }

    /**
     * Export documents
     *
     * @param ExportModel $document
     *
     * @return mixed
     *
     * @throws \Exception
     *
     * @deprecated
     * @see ExportService::create()
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
     *
     * @deprecated
     * @see ExportService::get()
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

    /**
     * Extract document fields
     * @param string $documentId
     * @return Field[]
     * @throws \Exception
     */
    public function fields(string $documentId): array
    {
        $url = $this->resolveEndpoint("/documents/$documentId/fields");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Field::createFromCollection($content);
    }

    /**
     * @param $url string
     * @param array $filter
     * @param array $options
     * @return array
     * @throws \Exception
     */
    protected function getDocuments($url, $filter = [], array $options = [])
    {
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
     * @param string $documentId
     * @param UpdateFields $fields
     * @return Document
     * @throws \Exception
     */
    public function updateFields(string $documentId, UpdateFields $fields): Document
    {
        $url = $this->resolveEndpoint("/documents/$documentId/fields");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $fields->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromOne($content);
    }

    public function addAttachments(string $documentId, AddAttachments $addAttachments)
    {
        $url = $this->resolveEndpoint("/documents/$documentId/attachments");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $addAttachments->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentAttachment::createFromCollection($content);
    }

    /**
     * @param string $documentId
     * @return array
     * @throws \Exception
     */
    public function getDocumentAttachments(string $documentId): array
    {
        $url = $this->resolveEndpoint("/documents/$documentId/document-attachments");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentAttachment::createFromCollection($content);
    }

    /**
     * @param string $documentId
     * @param AddDocumentAttachments $addDocumentAttachments
     * @return DocumentAttachment
     * @throws \Exception
     */
    public function addDocumentAttachments(
        string $documentId,
        AddDocumentAttachments $addDocumentAttachments
    ): DocumentAttachment {
        $url = $this->resolveEndpoint("/documents/$documentId/document-attachments");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $addDocumentAttachments->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentAttachment::createFromOne($content);
    }

    /**
     * @param string $documentId
     * @param string $documentAttachmentId
     */
    public function deleteDocumentAttachments(string $documentId, string $documentAttachmentId): void
    {
        $url = $this->resolveEndpoint("/documents/$documentId/document-attachments/$documentAttachmentId");

        $this->httpClient->delete($url);
    }
}
