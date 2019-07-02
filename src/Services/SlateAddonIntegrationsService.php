<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Addons\SlateAddonIntegration;
use Exception;
use function GuzzleHttp\json_decode;

class SlateAddonIntegrationsService extends AbstractService
{
    /**
     * @param string $slateAddonIntegrationId
     * @return SlateAddonIntegration
     * @throws Exception
     */
    public function get(string $slateAddonIntegrationId): SlateAddonIntegration
    {
        $url = $this->resolveEndpoint("/slate-addon-integrations/$slateAddonIntegrationId");

        $response = $this->httpClient->get($url);

        $content = json_decode($response->getBody(), true);

        return SlateAddonIntegration::createFromOne($content);
    }

    /**
     * @param string $slateAddonIntegrationId
     * @return SlateAddonIntegration
     * @throws Exception
     */
    public function refresh(string $slateAddonIntegrationId): SlateAddonIntegration
    {
        $url = $this->resolveEndpoint("/slate-addon-integrations/refresh-token/$slateAddonIntegrationId");

        $response = $this->httpClient->patch($url);

        $content = json_decode($response->getBody(), true);

        return SlateAddonIntegration::createFromOne($content);
    }
}
