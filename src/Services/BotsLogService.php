<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use GuzzleHttp\RequestOptions;
use AirSlate\ApiClient\Entities\BotsLog;
use AirSlate\ApiClient\Models\BotsLog\Create;
use AirSlate\ApiClient\Models\BotsLog\Update;

class BotsLogService extends AbstractService
{
    /**
     * @param string $flowUid
     * @param Create $botsLog
     * @return BotsLog
     */
    public function create(string $flowUid, Create $botsLog): BotsLog
    {
        $url = $this->resolveEndpoint("addons/slates/{$flowUid}/addon-logs");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $botsLog->toArray(),
        ]);

        $content = $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return BotsLog::createFromOne($content);
    }

    /**
     * @param string $flowUid
     * @param string $uid
     * @param Update $botsLog
     * @return BotsLog
     */
    public function update(string $flowUid, string $uid, Update $botsLog): BotsLog
    {
        $url = $this->resolveEndpoint("/addons/slates/{$flowUid}/addon-logs/{$uid}");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $botsLog->toArray(),
        ]);

        $content = $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return BotsLog::createFromOne($content);
    }
}
