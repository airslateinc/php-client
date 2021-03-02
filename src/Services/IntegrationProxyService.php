<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\IntegrationProxy\JsonRequest;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\RequestOptions;

class IntegrationProxyService extends AbstractService
{
    /**
     * @param JsonRequest $request
     * @return ResponseInterface
     */
    public function proxyRequest(JsonRequest $request)
    {
        $url = $this->resolveEndpoint("/integration-requests");

        return $this->httpClient->post($url, [
            RequestOptions::JSON => $request->toArray()
        ]);
    }
}
