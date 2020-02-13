<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Contracts\Services\AsyncService;
use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\Field;
use Exception;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Promise;

/**
 * Class AddonFlowDocumentsService
 * @package AirSlate\ApiClient\Services
 */
class AddonFlowDocumentsService extends AbstractService implements AsyncService
{
    /**
     * @param string $flowUid
     * @return Document[]
     * @throws Exception
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
     * @throws Exception
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
     * @param int $concurrency
     * @return array
     */
    public function fieldsAsync(
        string $flowUid,
        array $documentsIds,
        int $concurrency = self::DEFAULT_CONCURRENCY
    ): array {
        $results = [];

        $requestPool = function () use ($flowUid, $documentsIds) {
            foreach ($documentsIds as $documentUid) {
                $url = $this->resolveEndpoint("/addons/slates/{$flowUid}/documents/{$documentUid}/fields");

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
}
