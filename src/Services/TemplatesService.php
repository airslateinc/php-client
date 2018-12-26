<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\Template;
use AirSlate\ApiClient\Models\Template\Create;
use AirSlate\ApiClient\Models\Template\TemplateDocument;
use AirSlate\ApiClient\Models\Template\Update;
use GuzzleHttp\RequestOptions;

/**
 * TODO slateId should become required parameter in method calls. It is bad practice to make state dependant services
 *
 * Class TemplatesService
 * @package AirSlate\ApiClient\Services
 */
class TemplatesService extends AbstractService
{
    protected $slateId;

    /**
     * @param string $slateId
     *
     * @return Template[]
     * @throws \Exception
     */
    public function collection(string $slateId = null): array
    {
        $slateId = $slateId ?? $this->slateId;
        $url = $this->resolveEndpoint('/slates/' . $slateId . '/templates');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromCollection($content);
    }

    /**
     * @param string $templateId
     * @return Template
     * @throws \Exception
     */
    public function get(string $templateId): Template
    {
        $url = $this->resolveEndpoint('/slates/' . $this->slateId . '/templates/' . $templateId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @deprecated
     *
     * @return mixed
     */
    public function getSlateId()
    {
        return $this->slateId;
    }

    /**
     * @deprecated
     *
     * @param string $slateId
     * @return TemplatesService
     */
    public function setSlateId($slateId): TemplatesService
    {
        $this->slateId = $slateId;

        return $this;
    }

    /**
     * @param Create $template
     * @param string $slateId
     * @return Template
     * @throws \Exception
     */
    public function create(Create $template, string $slateId = null): Template
    {
        $slateId = $slateId ?? $this->slateId;
        $url = $this->resolveEndpoint('/slates/' . $slateId . '/templates');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $template->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param Update $template
     * @param string $slateId
     * @param string $templateId
     * @return Template
     * @throws \Exception
     */
    public function update(Update $template, string $slateId, string $templateId): Template
    {
        $url = $this->resolveEndpoint('/slates/' . $slateId . '/templates/' . $templateId);

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $template->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param string $slateId
     * @param string $templateId
     * @return array
     * @throws \Exception
     */
    public function documents(string $slateId, string $templateId): array
    {
        $url = $this->resolveEndpoint('/slates/' . $slateId . '/templates/' . $templateId . '/documents');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @param string $templateId
     * @param TemplateDocument $document
     * @return Template
     * @throws \Exception
     */
    public function addDocument(string $slateId, string $templateId, TemplateDocument $document): Template
    {
        $url = $this->resolveEndpoint('/slates/' . $slateId . '/templates/' . $templateId . '/documents');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $document->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param string $slateId
     * @param string $templateId
     * @param string $documentId
     * @return bool
     */
    public function deleteDocument(string $slateId, string $templateId, string $documentId)
    {
        $url = $this->resolveEndpoint('/slates/' . $slateId . '/templates/' .
            $templateId . '/documents/' . $documentId);
        $response = $this->httpClient->delete($url);

        return $response && $response->getStatusCode() === 204;
    }
}
