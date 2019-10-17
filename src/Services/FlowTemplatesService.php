<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\DocumentRole;
use AirSlate\ApiClient\Entities\Template;
use AirSlate\ApiClient\Models\Template\Create;
use AirSlate\ApiClient\Models\Template\TemplateDocument;
use AirSlate\ApiClient\Models\Template\Update;
use GuzzleHttp\RequestOptions;

/**
 * Class FlowTemplatesService
 * @package AirSlate\ApiClient\Services
 */
class FlowTemplatesService extends AbstractService
{
    /**
     * @param string $flowId
     *
     * @return Template[]
     * @throws \Exception
     */
    public function collection(string $flowId): array
    {
        $url = $this->resolveEndpoint('/flows/' . $flowId . '/templates');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromCollection($content);
    }

    /**
     * @param string $flowId
     * @param string $templateId
     * @return Template
     * @throws \Exception
     */
    public function get(string $flowId, string $templateId): Template
    {
        $url = $this->resolveEndpoint('/flows/' . $flowId . '/templates/' . $templateId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param Create $template
     * @param string $flowId
     * @return Template
     * @throws \Exception
     */
    public function create(Create $template, string $flowId): Template
    {
        $url = $this->resolveEndpoint('/flows/' . $flowId . '/templates');

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
     * @throws \Exception
     */
    public function update(Update $template, string $flowId, string $templateId): Template
    {
        $url = $this->resolveEndpoint('/flows/' . $flowId . '/templates/' . $templateId);

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $template->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param string $flowId
     * @param string $templateId
     * @return array
     * @throws \Exception
     */
    public function documents(string $flowId, string $templateId): array
    {
        $url = $this->resolveEndpoint('/flows/' . $flowId . '/templates/' . $templateId . '/documents');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromCollection($content);
    }

    /**
     * @param string $flowId
     * @param string $templateId
     * @return array
     * @throws \Exception
     */
    public function roles(string $flowId, string $templateId): array
    {
        $url = $this->resolveEndpoint('/flows/' . $flowId . '/templates/' . $templateId . '/roles');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentRole::createFromCollection($content);
    }

    /**
     * @param string $flowId
     * @param string $templateId
     * @param TemplateDocument $document
     * @return Template
     * @throws \Exception
     */
    public function addDocument(string $flowId, string $templateId, TemplateDocument $document): Template
    {
        $url = $this->resolveEndpoint('/flows/' . $flowId . '/templates/' . $templateId . '/documents');

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
     */
    public function deleteDocument(string $flowId, string $templateId, string $documentId): bool
    {
        $url = $this->resolveEndpoint('/flows/' . $flowId . '/templates/' .
            $templateId . '/documents/' . $documentId);

        $response = $this->httpClient->delete($url);

        return $response && $response->getStatusCode() === 204;
    }
}
