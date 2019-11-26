<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\DocumentRole;
use AirSlate\ApiClient\Entities\Template;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;
use AirSlate\ApiClient\Models\Template\Create;
use AirSlate\ApiClient\Models\Template\TemplateDocument;
use AirSlate\ApiClient\Models\Template\Update;
use Generator;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

/**
 * Class FlowTemplatesService
 * @package AirSlate\ApiClient\Services
 */
class FlowTemplatesService extends AbstractService
{
    /**
     * @param string $flowUid
     *
     * @return Template[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function collection(string $flowUid): array
    {
        $url = $this->resolveEndpoint('/flows/' . $flowUid . '/templates');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @return Generator|Template[]
     */
    public function collectionIterator(string $flowUid): Generator
    {
        $url = $this->resolveEndpoint('/flows/' . $flowUid . '/templates');
        yield from $this->pagination()->resolve($url, new Template());
    }

    /**
     * @param string $flowId
     * @param string $templateId
     * @return Template
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function get(string $flowId, string $templateId): Template
    {
        $url = $this->resolveEndpoint("/flows/{$flowId}/templates/{$templateId}");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param Create $template
     * @param string $flowId
     * @return Template
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function create(Create $template, string $flowId): Template
    {
        $url = $this->resolveEndpoint("/flows/{$flowId}/templates");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $template->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param Update $template
     * @param string $flowId
     * @param string $templateId
     * @return Template
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function update(Update $template, string $flowId, string $templateId): Template
    {
        $url = $this->resolveEndpoint("/flows/{$flowId}/templates/{$templateId}");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $template->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param string $flowId
     * @param string $templateId
     * @return Document[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function documents(string $flowId, string $templateId): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowId}/templates/{$templateId}/documents");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromCollection($content);
    }

    /**
     * @param string $flowId
     * @param string $templateId
     * @return DocumentRole[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function roles(string $flowId, string $templateId): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowId}/templates/{$templateId}/roles");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentRole::createFromCollection($content);
    }

    /**
     * @param string $flowId
     * @param string $templateId
     * @param TemplateDocument $document
     * @return Template
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function addDocument(string $flowId, string $templateId, TemplateDocument $document): Template
    {
        $url = $this->resolveEndpoint("/flows/{$flowId}/templates/{$templateId}/documents");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $document->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param string $flowId
     * @param string $templateId
     * @param string $documentId
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function deleteDocument(string $flowId, string $templateId, string $documentId): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowId}/templates/{$templateId}/documents/{$documentId}");

        $response = $this->httpClient->delete($url);

        return $response && $response->getStatusCode() === 204;
    }
}
