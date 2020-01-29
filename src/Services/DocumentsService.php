<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\DTO\UpdateDocumentFieldsDTO;
use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\DocumentAttachment;
use AirSlate\ApiClient\Entities\DocumentPermissions;
use AirSlate\ApiClient\Entities\Field;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Models\Document\AddAttachments;
use AirSlate\ApiClient\Models\Document\AddDocumentAttachments;
use AirSlate\ApiClient\Models\Document\Create as CreateModel;
use AirSlate\ApiClient\Models\Document\DocumentEvent;
use AirSlate\ApiClient\Models\Document\Event;
use AirSlate\ApiClient\Models\Document\UnlockPdf;
use AirSlate\ApiClient\Models\Document\Update as UpdateModel;
use AirSlate\ApiClient\Models\Document\Duplicate as DuplicateModel;
use AirSlate\ApiClient\Models\Document\UpdateFields;
use AirSlate\ApiClient\Models\Document\Upload as UploadModel;
use Generator;
use GuzzleHttp\Promise;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

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
     * @return Generator|Document[]
     */
    public function collectionIterator(): Generator
    {
        $url = $this->resolveEndpoint('/documents');
        yield from $this->pagination()->resolve($url, Document::class);
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
     * @param string[] $documentsIds
     * @return array<Field[]>
     */
    public function fieldsAsync(array $documentsIds): array
    {
        $promises = array_map(function (string $documentId) {
            $url = $this->resolveEndpoint("/documents/{$documentId}/fields");

            return $this->httpClient->getAsync($url);
        }, $documentsIds);

        $results = Promise\unwrap($promises);
        return array_map(function (ResponseInterface $response) {
            $content = \GuzzleHttp\json_decode($response->getBody(), true);
            return Field::createFromCollection($content);
        }, $results);
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

    /**
     * @param UpdateDocumentFieldsDTO[] $documentFields
     * @return Document[]
     */
    public function updateFieldsAsync(array $documentFields): array
    {
        $promises = array_map(function (UpdateDocumentFieldsDTO $documentFieldsDTO) {
            $url = $this->resolveEndpoint("/documents/{$documentFieldsDTO->getDocumentUid()}/fields");

            return $this->httpClient->patchAsync($url, [
                RequestOptions::JSON => $documentFieldsDTO->getFields()->toArray(),
            ]);
        }, $documentFields);

        $results = Promise\unwrap($promises);
        return array_map(function (ResponseInterface $response) {
            $content = \GuzzleHttp\json_decode($response->getBody(), true);
            return Document::createFromOne($content);
        }, $results);
    }

    /**
     * Unlock password-protected PDF-file previously uploaded with password
     * @param string $documentId
     * @param UnlockPdf $unlockPdf
     *
     * @return Document
     */
    public function unlockPdf(string $documentId, UnlockPdf $unlockPdf): Document
    {
        $url = $this->resolveEndpoint("/documents/$documentId/unlock-pdf");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $unlockPdf->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromOne($content);
    }

    /**
     * @param string $documentId
     * @param AddAttachments $addAttachments
     * @return array
     * @throws \Exception
     */
    public function addAttachments(string $documentId, AddAttachments $addAttachments)
    {
        // TODO Temp solution for migration to another endpoint
        $url = $this->resolveEndpoint("/documents/$documentId/attachments-external");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $addAttachments->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentAttachment::createFromCollection($content);
    }

    /**
     * @param string $documentId
     * @return DocumentAttachment[]
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
     * @param string $userId
     * @param string $type
     * @return DocumentAttachment[]
     * @throws \Exception
     */
    public function getDocumentAttachmentsByUser(string $userId, string $type): array
    {
        $url = $this->resolveEndpoint("/documents/document-attachments");
        $response = $this->httpClient->get($url, [
            'query' => [
                'user_uid' => $userId,
                'type' => $type,
            ],
        ]);

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

    /**
     * @param string $documentId
     * @param string $type
     * @return bool
     */
    public function event(string $documentId, string $type): bool
    {
        $url = $this->resolveEndpoint("/documents/$documentId/event");

        $event = Event::createFromType($type);

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $event->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return !empty($content->response);
    }

    /**
     * @param string $documentId
     * @return Document
     * @throws \Exception
     */
    public function documentContent(string $documentId): Document
    {
        $url = $this->resolveEndpoint("/documents/$documentId/content");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromOne($content);
    }

    /**
     * @param string $documentId
     * @return DocumentPermissions|null
     * @throws \Exception
     */
    public function documentPermissions(string $documentId): ?DocumentPermissions
    {
        $url = $this->resolveEndpoint("/documents/$documentId/permissions");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        $model = DocumentPermissions::createFromOne($content);

        return $model->hasPermissions() ? $model : null;
    }

    /**
     * @param DocumentEvent $documentEvent
     * @return bool
     */
    public function editorEvent(DocumentEvent $documentEvent): bool
    {
        $url = $this->resolveEndpoint("/documents/editor-events");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $documentEvent->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return !empty($content['meta']['ok']);
    }
}
