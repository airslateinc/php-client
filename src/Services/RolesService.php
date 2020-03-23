<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slates\FlowRole;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;
use AirSlate\ApiClient\Models\Role\Create;
use AirSlate\ApiClient\Models\Role\Delete;
use Generator;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

class RolesService extends AbstractService
{
    /**
     * @param string $flowUid
     * @return FlowRole[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function collection(string $flowUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/roles");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRole::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @return Generator|FlowRole[]
     */
    public function collectionIterator(string $flowUid): Generator
    {
         $url = $this->resolveEndpoint("/flows/{$flowUid}/roles");
         yield from $this->pagination()->resolve($url, FlowRole::class);
    }

    /**
     * @param string $flowUid
     * @param Create $roles
     * @return FlowRole[]
     * @throws InvalidArgumentException
     * @throws MissingDataException
     * @throws TypeMismatchException
     * @throws DomainException
     */
    public function create(string $flowUid, Create $roles): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/roles");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $roles->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRole::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param Delete $roles
     * @return bool
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function delete(string $flowUid, Delete $roles): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/roles");

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $roles->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}
