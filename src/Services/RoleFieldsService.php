<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slates\FlowRoleField;
use AirSlate\ApiClient\Models\RoleField\Create;
use AirSlate\ApiClient\Models\RoleField\Delete;
use AirSlate\ApiClient\Models\RoleField\Update;
use Generator;
use GuzzleHttp\RequestOptions;

class RoleFieldsService extends AbstractService
{
    /**
     * @param string $flowUid
     * @return FlowRoleField[]
     * @throws \Exception
     */
    public function collection(string $flowUid): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-fields");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleField::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @yield FlowRoleField
     * @return Generator
     */
    public function collectionIterator(string $flowUid): Generator
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-fields");
        yield from $this->pagination()->resolve($url, new FlowRoleField());
    }

    /**
     * @param string $flowUid
     * @param Create $roleFields
     * @return FlowRoleField[]
     * @throws \Exception
     */
    public function create(string $flowUid, Create $roleFields): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-fields");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $roleFields->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleField::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param Update $roleFields
     * @return FlowRoleField[]
     * @throws \Exception
     */
    public function update(string $flowUid, Update $roleFields): array
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-fields");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $roleFields->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleField::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param Delete $roleFields
     * @return bool
     */
    public function delete(string $flowUid, Delete $roleFields): bool
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/role-fields");

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $roleFields->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}
