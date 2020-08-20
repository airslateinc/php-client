<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\CloudStorage\DataProvideResponse;
use AirSlate\ApiClient\Models\CloudStorage\Provide;
use AirSlate\ApiClient\Models\CloudStorage\Subscribe;
use GuzzleHttp\RequestOptions;

class CloudStorageService extends AbstractService
{
    /**
     * @param Subscribe $subscribe
     * @return bool
     */
    public function subscribe(Subscribe $subscribe): bool
    {
        $url = $this->resolveEndpoint('/cloud-storage/subscribe');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $subscribe->toArray(),
        ]);

        return $response && $response->getStatusCode() === 201;
    }

    /**
     * @param Provide $provide
     * @return DataProvideResponse
     */
    public function provide(Provide $provide): DataProvideResponse
    {
        $url = $this->resolveEndpoint('/cloud-storage/provide');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $provide->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return DataProvideResponse::createFromOne($content);
    }
}
