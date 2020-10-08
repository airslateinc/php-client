<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\DTO\UpdateDocumentFieldsDTO;
use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\DocumentAttachment;
use AirSlate\ApiClient\Entities\DocumentPermissions;
use AirSlate\ApiClient\Entities\EditorOptions;
use AirSlate\ApiClient\Entities\Field;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Models\Document\AddAttachments;
use AirSlate\ApiClient\Models\Document\AddDocumentAttachments;
use AirSlate\ApiClient\Models\Document\AddDocumentAttachmentFile;
use AirSlate\ApiClient\Models\Document\AttachmentFileRename;
use AirSlate\ApiClient\Models\Document\BulkEditorOptionsUpdate;
use AirSlate\ApiClient\Models\Document\Create as CreateModel;
use AirSlate\ApiClient\Models\Document\DocumentEvent;
use AirSlate\ApiClient\Models\Document\DocumentFiles;
use AirSlate\ApiClient\Models\Document\EditorOptionsUpdate;
use AirSlate\ApiClient\Models\Document\Event;
use AirSlate\ApiClient\Models\Document\UnlockPdf;
use AirSlate\ApiClient\Models\Document\Update as UpdateModel;
use AirSlate\ApiClient\Models\Document\Duplicate as DuplicateModel;
use AirSlate\ApiClient\Models\Document\UpdateFields;
use AirSlate\ApiClient\Models\Document\Upload as UploadModel;
use Exception;
use Generator;
use GuzzleHttp\Promise;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class DocumentsService
 * @package AirSlate\ApiClient\Services
 */
class DocumentsService extends AbstractService
{
    /** @const int */
    private const DOCUMENTS_IDS_CHUNK_SIZE = 15;

    /**
     * Create document
     *
     * @param CreateModel $document
     * @return Document
     * @throws Exception
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
     * @throws Exception
     */
    public function update(UpdateModel $document): Document
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
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
     */
    public function collection($filter = [], array $options = []): array
    {
        $url = $this->resolveEndpoint('/documents');
        return $this->getDocuments($url, $filter, $options);
    }

    /**
     * @param array $documentIds
     * @param int $concurrency
     * @return array
     */
    public function collectionAsync(array $documentIds, int $concurrency = self::DEFAULT_CONCURRENCY): array
    {
        $results = [];
        $requestPool = function () use ($documentIds) {
            foreach (array_chunk($documentIds, self::DOCUMENTS_IDS_CHUNK_SIZE) as $idsChunk) {
                $url = $url = $this->resolveEndpoint('/documents');

                $httpClient = clone $this->httpClient;
                $httpClient->addFilter('id', $idsChunk);

                yield $httpClient->getAsync($url)->then(function (ResponseInterface $response) {
                    $content = \GuzzleHttp\json_decode($response->getBody(), true);
                    return Document::createFromCollection($content);
                });
            }

            $this->httpClient->clearOptions();
        };

        Promise\each_limit_all(
            $requestPool(),
            $concurrency,
            function (array $result) use (&$results) {
                $results = array_merge($results, $result);
            }
        )->wait();

        return $results;
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
     * @throws Exception
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
     * @throws Exception
     */
    public function fields(string $documentId): array
    {
        $url = $this->resolveEndpoint("/documents/$documentId/fields");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Field::createFromCollection($content);
    }

    /**
     * @param array $documentsIds
     * @param int $concurrency
     * @return array
     */
    public function fieldsAsync(array $documentsIds, int $concurrency = self::DEFAULT_CONCURRENCY): array
    {
        $results = [];
        $requestPool = function () use ($documentsIds) {
            foreach ($documentsIds as $documentUid) {
                $url = $this->resolveEndpoint("/documents/{$documentUid}/fields");

                yield $documentUid => $this->httpClient->getAsync($url)->then(function (ResponseInterface $response) {
                    $content = \GuzzleHttp\json_decode($response->getBody(), true);
                    return Field::createFromCollection($content);
                });
            }
        };

        Promise\each_limit_all(
            $requestPool(),
            $concurrency,
            function (array $result, string $documentId) use (&$results) {
                $results[$documentId] = $result;
            }
        )->wait();

        return $results;
    }

    /**
     * @param $url string
     * @param array $filter
     * @param array $options
     * @return array
     * @throws Exception
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
     * @throws Exception
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
     * @param int $concurrency
     * @return Document[]
     * @throws Throwable
     */
    public function updateFieldsAsync(array $documentFields, int $concurrency = self::DEFAULT_CONCURRENCY): array
    {
        $results = [];
        $requestPool = function () use ($documentFields) {
            foreach ($documentFields as $documentFieldsDTO) {
                $url = $this->resolveEndpoint("/documents/{$documentFieldsDTO->getDocumentUid()}/fields");

                yield $this->httpClient->patchAsync($url, [
                    RequestOptions::JSON => $documentFieldsDTO->getFields()->toArray(),
                ])->then(function (ResponseInterface $response) {
                    $content = \GuzzleHttp\json_decode($response->getBody(), true);
                    return Document::createFromOne($content);
                });
            }
        };

        Promise\each_limit_all(
            $requestPool(),
            $concurrency,
            function (Document $result) use (&$results) {
                $results[] = $result;
            }
        )->wait();

        return $results;
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
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
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
     * @param AddDocumentAttachmentFile $addDocumentAttachmentFile
     * @return DocumentAttachment
     * @throws Exception
     */
    public function addDocumentAttachmentFile(
        string $documentId,
        AddDocumentAttachmentFile $addDocumentAttachmentFile
    ): DocumentAttachment {
        $url = $this->resolveEndpoint("/documents/$documentId/document-attachments/files");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $addDocumentAttachmentFile->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentAttachment::createFromOne($content);
    }

    /**
     * @param string $documentUid
     * @param string $attachmentUid
     * @param AttachmentFileRename $attachmentFileRename
     * @return DocumentAttachment
     */
    public function renameDocumentAttachment(
        string $documentUid,
        string $attachmentUid,
        AttachmentFileRename $attachmentFileRename
    ): DocumentAttachment {
        $url = $this->resolveEndpoint("/documents/{$documentUid}/document-attachments/{$attachmentUid}/rename");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $attachmentFileRename->toArray(),
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
     * @throws Exception
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
     * @throws Exception
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
     * @param string $documentId
     * @return EditorOptions|null
     * @throws Exception
     */
    public function editorOptions(string $documentId): ?EditorOptions
    {
        $url = $this->resolveEndpoint("/documents/$documentId/editor-options");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return EditorOptions::createFromOne($content);
    }

    /**
     * @param string $documentUid
     * @param EditorOptionsUpdate $editorOptions
     * @return EditorOptions
     */
    public function updateEditorOptions(string $documentUid, EditorOptionsUpdate $editorOptions): EditorOptions
    {
        $url = $this->resolveEndpoint("/documents/$documentUid/editor-options");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $editorOptions->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return EditorOptions::createFromOne($content);
    }

    /**
     * @param BulkEditorOptionsUpdate $editorOptions
     * @return EditorOptions[]|array
     */
    public function bulkUpdateEditorOptions(BulkEditorOptionsUpdate $editorOptions): array
    {
        $url = $this->resolveEndpoint("/documents/editor-options/bulk");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $editorOptions->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return EditorOptions::createFromCollection($content);
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

    /**
     * @param string $documentUid
     * @param DocumentFiles $documentFiles
     * @return Document
     */
    public function uploadDocumentFiles(string $documentUid, DocumentFiles $documentFiles): Document
    {
        $url = $this->resolveEndpoint("/documents/$documentUid/files/bulk");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $documentFiles->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromOne($content);
    }
}
