<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Organization;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Models\Organization\Create;
use AirSlate\ApiClient\Models\Organization\Update;
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
     * @param string|null $userToken
     * @return Organization
     */
    public function create(Create $organization, ?string $userToken = null): Organization
    {
        $url = $this->resolveEndpoint('/organizations');
        $opts = [
            RequestOptions::JSON => $organization->toArray(),
        ];

        if ($userToken) {
            $opts[RequestOptions::HEADERS] = [
                'Authorization' => "Bearer {$userToken}",
            ];
        }

        $response = $this->httpClient->post($url, $opts);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Organization::createFromOne($content);
    }

    /**
     * @param Update $organization
     * @param string|null $userToken
     * @return Organization
     */
    public function update(Update $organization, ?string $userToken = null): Organization
    {
        $url = $this->resolveEndpoint("/organizations/{$organization->getOrganizationUid()}");
        $opts = [
            RequestOptions::JSON => $organization->toArray(),
        ];

        if ($userToken) {
            $opts[RequestOptions::HEADERS] = [
                'Authorization' => "Bearer {$userToken}",
            ];
        }

        $response = $this->httpClient->patch($url, $opts);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Organization::createFromOne($content);
    }

    /**
     * @param string $organizationUid
     * @param string|null $userToken
     * @return Organization
     */
    public function one(string $organizationUid, ?string $userToken = null): Organization
    {
        $url = $this->resolveEndpoint("/organizations/{$organizationUid}");
        $this->addQueryParam('include', 'owner');
        $opts = [];
        if ($userToken) {
            $opts[RequestOptions::HEADERS] = [
                'Authorization' => "Bearer {$userToken}",
            ];
        }

        $response = $this->httpClient->get($url, $opts);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Organization::createFromOne($content);
    }
}
