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
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

/**
 * @deprecated
 * @see \AirSlate\ApiClient\Services\FlowTemplatesService
 *
 * Class TemplatesService
 * @package AirSlate\ApiClient\Services
 */
class TemplatesService extends AbstractService
{
    /**
     * @param string $flowUid
     * @return Template[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function collection(string $flowUid): array
    {
        $url = $this->resolveEndpoint("/slates/{$flowUid}/templates");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromCollection($content);
    }

    /**
     * @param string $templateUid
     * @return Template
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function get(string $flowUid, string $templateUid): Template
    {
        $url = $this->resolveEndpoint("/slates/{$flowUid}/templates/{$templateUid}");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param Create $template
     * @param string $flowUid
     * @return Template
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function create(Create $template, string $flowUid): Template
    {
        $url = $this->resolveEndpoint("/slates/{$flowUid}/templates");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $template->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param Update $template
     * @param string $flowUid
     * @param string $templateUid
     * @return Template
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function update(string $flowUid, string $templateUid, Update $template): Template
    {
        $url = $this->resolveEndpoint("/slates/{$flowUid}/templates/{$templateUid}");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $template->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param string $templateUid
     * @return Document[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function documents(string $flowUid, string $templateUid): array
    {
        $url = $this->resolveEndpoint("/slates/{$flowUid}/templates/{$templateUid}/documents");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $templateUid
     * @return DocumentRole[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function roles(string $flowUid, string $templateUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/templates/{$templateUid}/roles");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentRole::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $templateUid
     * @param TemplateDocument $document
     * @return Template
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function addDocument(string $flowUid, string $templateUid, TemplateDocument $document): Template
    {
        $url = $this->resolveEndpoint("/slates/{$flowUid}/templates/{$templateUid}/documents");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $document->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param string $templateUid
     * @param string $documentUid
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function deleteDocument(string $flowUid, string $templateUid, string $documentUid): bool
    {
        $url = $this->resolveEndpoint("/slates/{$flowUid}/templates/{$templateUid}/documents/{$documentUid}");

        $response = $this->httpClient->delete($url);

        return $response && $response->getStatusCode() === 204;
    }
}
