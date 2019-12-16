<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\Field;

/**
 * Class AddonFlowDocumentsService
 * @package AirSlate\ApiClient\Services
 */
class AddonFlowDocumentsService extends AbstractService
{
    /**
     * @param string $flowUid
     * @return Document[]
     * @throws \Exception
     */
    public function collection(string $flowUid): array
    {
        $url = $this->resolveEndpoint("/addons/slates/{$flowUid}/documents");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $documentUid
     * @return Field[]
     * @throws \Exception
     */
    public function fields(string $flowUid, string $documentUid): array
    {
        $url = $this->resolveEndpoint("/addons/slates/{$flowUid}/documents/{$documentUid}/fields");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Field::createFromCollection($content);
    }
}
