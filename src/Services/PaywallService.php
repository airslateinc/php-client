<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Plan;

class PaywallService extends AbstractService
{
    /**
     * @return Plan[]
     */
    public function plans(): array
    {
        $url = $this->resolveEndpoint('/plans');
        $response = $this->httpClient->get($url);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Plan::createFromCollection($content);
    }
}
