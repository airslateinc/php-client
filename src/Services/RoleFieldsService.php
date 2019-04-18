<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slates\FlowRoleField;
use AirSlate\ApiClient\Models\RoleField\Create;
use AirSlate\ApiClient\Models\RoleField\Delete;
use AirSlate\ApiClient\Models\RoleField\Update;
use GuzzleHttp\RequestOptions;

class RoleFieldsService extends AbstractService
{
    /**
     * @param string $slateId
     * @return FlowRoleField[]
     * @throws \Exception
     */
    public function collection(string $slateId): array
    {
        $url = $this->resolveEndpoint("/flows/{$slateId}/role-fields");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleField::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @param Create $roleFields
     * @return FlowRoleField[]
     * @throws \Exception
     */
    public function create(string $slateId, Create $roleFields): array
    {
        $url = $this->resolveEndpoint("/flows/{$slateId}/role-fields");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $roleFields->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleField::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @param Update $roleFields
     * @return FlowRoleField[]
     * @throws \Exception
     */
    public function update(string $slateId, Update $roleFields): array
    {
        $url = $this->resolveEndpoint("/flows/{$slateId}/role-fields");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $roleFields->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleField::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @param Delete $roleFields
     * @return bool
     */
    public function delete(string $slateId, Delete $roleFields): bool
    {
        $url = $this->resolveEndpoint("/flows/{$slateId}/role-fields");

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $roleFields->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}