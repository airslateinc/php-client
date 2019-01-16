<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Addons\AddonIntegration;

class AddonIntegrationsService extends AbstractService
{
    /**
     * @param string $addonIntegrationId
     * @return AddonIntegration
     * @throws \Exception
     */
    public function get(string $addonIntegrationId)
    {
        $url = $this->resolveEndpoint("/addons/integrations/$addonIntegrationId");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return AddonIntegration::createFromOne($content);
    }

    /**
     * @param string $addonIntegrationId
     * @return AddonIntegration
     * @throws \Exception
     */
    public function refresh(string $addonIntegrationId)
    {
        $url = $this->resolveEndpoint("/addons/integrations/refresh-token/$addonIntegrationId");

        $response = $this->httpClient->patch($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return AddonIntegration::createFromOne($content);
    }
}
