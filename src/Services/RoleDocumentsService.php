<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slates\FlowRoleDocuments;
use AirSlate\ApiClient\Models\RoleDocument\Create;
use AirSlate\ApiClient\Models\RoleDocument\Delete;
use AirSlate\ApiClient\Models\RoleDocument\Update;
use GuzzleHttp\RequestOptions;

class RoleDocumentsService extends AbstractService
{
    /** @var string */
    protected $slateId;

    /**
     * @param string $slateId
     * @return RoleDocumentsService
     */
    public function setSlateId($slateId): RoleDocumentsService
    {
        $this->slateId = $slateId;

        return $this;
    }

    /**
     * @return FlowRoleDocuments[]
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/role-documents");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleDocuments::createFromCollection($content);
    }

    /**
     * @param Create $roleDocuments
     * @return array
     * @throws \Exception
     */
    public function create(Create $roleDocuments): array
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/role-documents");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $roleDocuments->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleDocuments::createFromCollection($content);
    }

    /**
     * @param Update $roleDocuments
     * @return array
     * @throws \Exception
     */
    public function update(Update $roleDocuments): array
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/role-documents");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $roleDocuments->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FlowRoleDocuments::createFromCollection($content);
    }

    /**
     * @param Delete $roleDocuments
     * @return bool
     */
    public function delete(Delete $roleDocuments): bool
    {
        $url = $this->resolveEndpoint("/flows/{$this->slateId}/role-documents");

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $roleDocuments->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}