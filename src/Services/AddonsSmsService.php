<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\EntityType;
use GuzzleHttp\RequestOptions;

class AddonsSmsService extends AbstractService
{

    /**
     * @param string $phone
     * @param string $message
     */
    public function send(string $phone, string $message): void
    {
        $url = $this->resolveEndpoint('/addons-sms/send');

        $payload = [
            'data' => [
                'type' => EntityType::ADDON_SMS,
                'attributes' => [
                    'phone' => $phone,
                    'message' => $message
                ],
            ],
        ];

        $this->httpClient->post($url, [
            RequestOptions::JSON => $payload,
        ]);
    }
}
