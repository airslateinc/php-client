<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Addons\OrganizationAddon;
use AirSlate\ApiClient\Models\OrganizationAddon\Create as CreateOrganizationAddon;
use Generator;
use GuzzleHttp\RequestOptions;

class OrganizationAddonsService extends AbstractService
{
    /**
     * @param CreateOrganizationAddon $model
     * @return OrganizationAddon
     * @throws \Exception
     */
    public function create(CreateOrganizationAddon $model): OrganizationAddon
    {
        $url = $this->resolveEndpoint('/organization-addons');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $model->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return OrganizationAddon::createFromOne($content);
    }

    /**
     * @param string $organizationAddonId
     * @return bool
     */
    public function delete(string $organizationAddonId): bool
    {
        $url = $this->resolveEndpoint('/organization-addons/' . $organizationAddonId);

        $response = $this->httpClient->delete($url);

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param string $organizationAddonId
     * @return OrganizationAddon
     * @throws \Exception
     */
    public function get(string $organizationAddonId): OrganizationAddon
    {
        $url = $this->resolveEndpoint('/organization-addons/' . $organizationAddonId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return OrganizationAddon::createFromOne($content);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/organization-addons');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return OrganizationAddon::createFromCollection($content);
    }

    /**
     * @return Generator
     */
    public function collectionIterator(): Generator
    {
        $page = 0;
        $url = $this->resolveEndpoint('/organization-addons');

        do {
            $page++;

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            yield from OrganizationAddon::createFromCollection($content);
        } while ($content['meta']['current_page'] < $content['meta']['last_page']);
    }
}
