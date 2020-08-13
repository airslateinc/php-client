<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\Notifications\Send;
use GuzzleHttp\RequestOptions;

class NotificationsService extends AbstractService
{
    /**
     * @param Send $notification
     * @return bool
     */
    public function send(Send $notification): bool
    {
        $url = $this->resolveEndpoint('/notifications');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $notification->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}
