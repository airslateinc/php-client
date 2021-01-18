<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\FlowLibrary\DocumentTemplate;

/**
 * Class DocumentTemplatesService
 * @package AirSlate\ApiClient\Services
 */
class DocumentTemplatesService extends AbstractService
{
    public function get(string $templateId): DocumentTemplate
    {
        $url = $this->resolveEndpoint("/flow-library-api/document_templates/$templateId");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DocumentTemplate::createFromOne($content);
    }
}
