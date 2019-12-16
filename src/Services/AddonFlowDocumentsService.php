<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\Field;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;
use InvalidArgumentException;

/**
 * Class AddonFlowDocumentsService
 * @package AirSlate\ApiClient\Services
 */
class AddonFlowDocumentsService extends AbstractService
{
    /**
     * @param string $flowUid
     * @return Document[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function collection(string $flowUid): array
    {
        $url = $this->resolveEndpoint("/addons/slates/{$flowUid}//documents");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $documentUid
     * @return Field[]
     */
    public function fields(string $flowUid, string $documentUid): array
    {
        $url = $this->resolveEndpoint("/addons/slates/{$flowUid}/documents/{$documentUid}/fields");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Field::createFromCollection($content);
    }
}
