<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\LookupOrganization;
use AirSlate\ApiClient\Entities\Organization;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Models\Organization\Create;
use AirSlate\ApiClient\Models\Organization\Update;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class OrganizationsService extends AbstractService
{
    /**
     * @param string $subdomain
     * @return bool
     */
    public function subdomainExists(string $subdomain): bool
    {
        try {
            $this->httpClient->get(
                $this->resolveEndpoint("/subdomain/{$subdomain}")
            );
        } catch (DomainException $e) {
            if ($e->getCode() === 404) {
                return false;
            }
            throw $e;
        }

        return true;
    }

    /**
     * @param Create $organization
     * @return Organization
     */
    public function create(Create $organization): Organization
    {
        $url = $this->resolveEndpoint('/organizations');
        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $organization->toArray(),
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Organization::createFromOne($content);
    }

    /**
     * @param Create $organization
     * @return Organization
     */
    public function createMSP(Create $organization): Organization
    {
        $url = $this->resolveEndpoint('/msp/organizations');
        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $organization->toArray(),
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Organization::createFromOne($content);
    }

    /**
     * @param Update $organization
     * @return Organization
     */
    public function update(Update $organization): Organization
    {
        $url = $this->resolveEndpoint("/organizations/{$organization->getOrganizationUid()}");
        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $organization->toArray(),
        ]);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Organization::createFromOne($content);
    }

    /**
     * @param string $organizationUid
     * @return Organization
     */
    public function one(string $organizationUid): Organization
    {
        $url = $this->resolveEndpoint("/organizations/{$organizationUid}");
        $response = $this->httpClient->get($url);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Organization::createFromOne($content);
    }

    /**
     * @param string $userUid
     * @return array
     * @throws GuzzleException
     */
    public function allByUser(string $userUid): array
    {
        $url = $this->resolveEndpoint("users/{$userUid}/organizations");
        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Organization::createFromCollection($content);
    }

    /**
     * @return LookupOrganization[]
     */
    public function lookup(): array
    {
        $url = $this->resolveEndpoint('/lookup/organizations');
        $response = $this->httpClient->get($url);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return LookupOrganization::createFromCollection($content);
    }
}
