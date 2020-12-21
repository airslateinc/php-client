<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage\Connection;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
{
    /**
     * @param array $resourceInformation
     * @param string $slateAddonIntegrationId
     * @param string $previousSlateAddonIntegrationId
     * @param string $organizationId
     */
    public function __construct(
        array $resourceInformation,
        string $slateAddonIntegrationId,
        string $previousSlateAddonIntegrationId,
        string $organizationId
    ) {
        $data = [
            'type' => 'connection_update_request',
            'attributes' => [
                'resource_information' => $resourceInformation,
            ],
            'relationships' => [
                'slate_addon_integrations_previous' => [
                    'data' => [
                        'type' => EntityType::SLATE_ADDON_INTEGRATION,
                        'id' => $previousSlateAddonIntegrationId,
                    ],
                ],
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
