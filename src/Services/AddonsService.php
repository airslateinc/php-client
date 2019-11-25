<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Addon;
use Generator;
use GuzzleHttp\RequestOptions;

class AddonsService extends AbstractService
{
    /**
     * Get access token for addon
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $organizationId
     * @return mixed
     */
    public function getAccessToken(
        string $clientId,
        string $clientSecret,
        string $organizationId
    ) {
        $url = $this->resolveEndpoint('/addon-token');

        $response = $this->httpClient->post($url, [
            RequestOptions::FORM_PARAMS => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'organization_id' => $organizationId
            ]
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return $content;
    }

    /**
     * @param string $addonId
     * @return Addon
     * @throws \Exception
     */
    public function get(string $addonId)
    {
        $url = $this->resolveEndpoint('/addons/' . $addonId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Addon::createFromOne($content);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function collection()
    {
        $url = $this->resolveEndpoint('/addons');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Addon::createFromCollection($content);
    }

    /**
     * @return Generator
     */
    public function collectionIterator(): Generator
    {
        $page = 0;
        $url = $this->resolveEndpoint('/addons');

        do {
            $page++;

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            yield Addon::createFromCollection($content);
        } while ($content['meta']['current_page'] < $content['meta']['last_page']);
    }

    /**
     * @return OrganizationAddonsService
     */
    public function organizationAddons(): OrganizationAddonsService
    {
        return new OrganizationAddonsService($this->httpClient);
    }

    /**
     * @return SlateAddonsService
     */
    public function slateAddons(): SlateAddonsService
    {
        return new SlateAddonsService($this->httpClient);
    }
    
    /**
     * @return AddonIntegrationsService
     */
    public function addonIntegrations(): AddonIntegrationsService
    {
        return new AddonIntegrationsService($this->httpClient);
    }
}
