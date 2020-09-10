<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\IntegrationProxy\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\RequestOptions;


class IntegrationProxyService extends AbstractService
{
    /**
     * @param Request $request
     * @return ResponseInterface
     */
    public function proxyRequest(Request $request)
    {
        $url = $this->resolveEndpoint("/integration-requests");

        return $this->httpClient->post($url, [
            RequestOptions::JSON => $request->toArray()
        ]);
    }
}
