<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Watch extends AbstractModel
{
    /**
     * @param array $resourceInformation
     * @param string $slateAddonIntegrationId
     * @param string $organizationId
     * @param string $callbackUrl
     */
    public function __construct(
        array $resourceInformation,
        string $slateAddonIntegrationId,
        string $organizationId,
        string $callbackUrl
    ) {
        $data = [
            'type' => 'data_storage_watch_request',
            'attributes' => [
                'resource_information' => $resourceInformation,
                'callback_url' => $callbackUrl,
            ],
            'relationships' => [
                'slate_addon_integrations' => [
                    'data' => [
                        'type' => EntityType::SLATE_ADDON_INTEGRATION,
                        'id' => $slateAddonIntegrationId,
                    ],
                ],
                'organizations' => [
                    'data' => [
                        'type' => EntityType::ORGANIZATION,
                        'id' => $organizationId,
                    ],
                ],
            ],
        ];

        parent::__construct($data);
    }
}
