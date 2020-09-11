<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\IntegrationProxy\ProxyRequest;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\RequestOptions;


class IntegrationProxyService extends AbstractService
{
    /**
     * @param ProxyRequest $request
     * @return ResponseInterface
     */
    public function proxyRequest(ProxyRequest $request)
    {
        $url = $this->resolveEndpoint("/integration-requests");

        return $this->httpClient->post($url, [
            RequestOptions::JSON => $request->toArray()
        ]);
    }
}
