<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slates\FlowRoleDocument;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;
use AirSlate\ApiClient\Models\RoleDocument\Create;
use AirSlate\ApiClient\Models\RoleDocument\Delete;
use AirSlate\ApiClient\Models\RoleDocument\Update;
use Generator;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

class RoleDocumentsService extends AbstractService
{
    /**
     * @param string $flowUid
     * @return FlowRoleDocument[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function collection(string $flowUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-documents");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleDocument::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @return Generator|FlowRoleDocument[]
     */
    public function collectionIterator(string $flowUid): Generator
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-documents");
        yield from $this->pagination()->resolve($url, FlowRoleDocument::class);
    }

    /**
     * @param string $flowUid
     * @param Create $roleDocuments
     * @return FlowRoleDocument[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function create(string $flowUid, Create $roleDocuments): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-documents");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $roleDocuments->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleDocument::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param Update $roleDocuments
     * @return FlowRoleDocument[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function update(string $flowUid, Update $roleDocuments): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-documents");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $roleDocuments->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleDocument::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param Delete $roleDocuments
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function delete(string $flowUid, Delete $roleDocuments): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-documents");

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $roleDocuments->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}
