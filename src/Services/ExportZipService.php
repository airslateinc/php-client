<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\ExportZip\Create;
use GuzzleHttp\RequestOptions;

class ExportZipService extends AbstractService
{
    /**
     * Create export zip
     *
     * @param Create $exportZip
     * @return array
     * @throws \Exception
     */
    public function create(Create $exportZip): array
    {
        $url = $this->resolveEndpoint('/export-zip');

        $response = $this->httpClient->post(
            $url,
            [
                RequestOptions::JSON => $exportZip->toArray(),
            ]
        );

        return \GuzzleHttp\json_decode($response->getBody(), true);
    }

    /**
     * Check the export zip status
     *
     * @param string $exportZipId
     * @return array
     * @throws \Exception
     */
    public function get(string $exportZipId): array
    {
        $url = $this->resolveEndpoint("/export-zip/{$exportZipId}");

        $response = $this->httpClient->get($url);

        return \GuzzleHttp\json_decode($response->getBody(), true);
    }
}
