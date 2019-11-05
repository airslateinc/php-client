<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use GuzzleHttp\RequestOptions;
use AirSlate\ApiClient\Entities\AddonLog;
use AirSlate\ApiClient\Models\AddonLogs\Create;
use AirSlate\ApiClient\Models\AddonLogs\Update;

class AddonLogsService extends AbstractService
{
    /**
     * @param string $flowUid
     * @param Create $addonLogs
     * @return AddonLog
     */
    public function create(string $flowUid, Create $addonLogs): AddonLog
    {
        $url = $this->resolveEndpoint("addons/slates/{$flowUid}/addon-logs");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $addonLogs->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return AddonLog::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param string $addonLogUid
     * @param Update $addonLogs
     * @return AddonLog
     */
    public function update(string $flowUid, string $addonLogUid, Update $addonLogs): AddonLog
    {
        $url = $this->resolveEndpoint("/addons/slates/{$flowUid}/addon-logs/{$addonLogUid}");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $addonLogs->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return AddonLog::createFromOne($content);
    }
}
