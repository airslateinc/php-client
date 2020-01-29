<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\Field;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Promise;
use Throwable;

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

    /**
     * @param string $flowUid
     * @param string[] $documentsIds
     * @return array
     * @throws Throwable
     */
    public function fieldsAsync(string $flowUid, array $documentsIds): array
    {
        $promises = array_map(function (string $documentUid) use ($flowUid) {
            $url = $this->resolveEndpoint("/addons/slates/{$flowUid}/documents/{$documentUid}/fields");

            return $this->httpClient->getAsync($url);
        }, $documentsIds);

        $results = Promise\unwrap($promises);
        return array_map(function (ResponseInterface $response) {
            $content = \GuzzleHttp\json_decode($response->getBody(), true);
            return Field::createFromCollection($content);
        }, $results);
    }
}
