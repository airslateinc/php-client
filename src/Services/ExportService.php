<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\Document\ExportSms;
use AirSlate\ApiClient\Models\Export\Create;
use GuzzleHttp\RequestOptions;

/**
 * Class ExportService
 * @package AirSlate\ApiClient\Services
 */
class ExportService extends AbstractService
{
    /**
     * Export documents
     *
     * @param Create $export
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function create(Create $export): array
    {
        $url = $this->resolveEndpoint('/export');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $export->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return $content;
    }

    /**
     * Check the export status
     *
     * @param string $exportId
     *
     * @return array
     */
    public function get(string $exportId): array
    {
        $url = $this->resolveEndpoint("/export/$exportId");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return $content;
    }

    /**
     * Check the export status
     *
     * @param string $exportId
     * @param ExportSms $exportSms
     * @return array
     */
    public function exportSms(string $exportId, ExportSms $exportSms): array
    {
        $url = $this->resolveEndpoint("/export/$exportId/envelopes/sms");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $exportSms->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return $content;
    }
}
