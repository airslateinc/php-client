<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Integration;

class IntegrationsService extends AbstractService
{
    protected const VERSION = 'v1';

    /**
     * @param string $integrationId
     * @return Integration
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function get(string $integrationId)
    {
        $url = $this->resolveEndpoint("/addons/integrations/$integrationId");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Integration::createFromOne($content);
    }
}
