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
     * @return Generator
     */
    public function collectionIterator(string $flowUid): Generator
    {
        $page = 0;
        do {
            $page++;

            $url = $this->resolveEndpoint("/flows/{$flowUid}/roles");

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            yield FlowRole::createFromCollection($content);
        } while ($content['meta']['current_page'] < $content['meta']['last_page']);
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
