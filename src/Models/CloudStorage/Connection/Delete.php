<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage\Connection;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Delete extends AbstractModel
{
    /**
     * @param array $resourceInformation
     * @param string $slateAddonIntegrationId
     * @param string $organizationId
     */
    public function __construct(
        array $resourceInformation,
        string $slateAddonIntegrationId,
        string $organizationId
    ) {
        $data = [
            'type' => 'connection_delete_request',
            'attributes' => [
                'resource_information' => $resourceInformation,
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
