<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slates\FlowRoles;
use AirSlate\ApiClient\Models\Role\Create;
use AirSlate\ApiClient\Models\Role\Delete;
use GuzzleHttp\RequestOptions;

class RolesService extends AbstractService
{
    /** @var string */
    protected $slateId;

    /**
     * @param string $slateId
     * @return RolesService
     */
    public function setSlateId($slateId): RolesService
    {
        $this->slateId = $slateId;

        return $this;
    }

    /**
     * @return FlowRoles[]
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/roles");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoles::createFromCollection($content);
    }

    /**
     * @param Create $roles
     * @return FlowRoles[]
     * @throws \Exception
     */
    public function create(Create $roles): array
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/roles");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $roles->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoles::createFromCollection($content);
    }

    /**
     * @param Delete $roles
     * @return bool
     */
    public function delete(Delete $roles): bool
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/roles");

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $roles->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}