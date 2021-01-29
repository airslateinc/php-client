<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\Notifications\Send;
use AirSlate\ApiClient\Models\Notifications\SendEmailsBulk;
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

    /**
     * @param SendEmailsBulk $sendEmailsBulk
     * @return bool
     */
    public function sendEmailsBulkSync(SendEmailsBulk $sendEmailsBulk): bool
    {
        $url = $this->resolveEndpoint('/notifications/send-emails-in-bulk/sync');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $sendEmailsBulk->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param SendEmailsBulk $sendEmailsBulk
     * @return bool
     */
    public function sendEmailsBulkAsync(SendEmailsBulk $sendEmailsBulk): bool
    {
        $url = $this->resolveEndpoint('/notifications/send-emails-in-bulk');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $sendEmailsBulk->toArray(),
        ]);

        return $response && $response->getStatusCode() === 202;
    }
}
