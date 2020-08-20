<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Subscribe extends AbstractModel
{
    /**
     * @param array $resourceIdentifier
     * @param string $slateAddonIntegrationId
     * @param string $organizationId
     */
    public function __construct(array $resourceIdentifier, string $slateAddonIntegrationId, string $organizationId)
    {
        $data = [
            'type' => 'data_storage_request',
            'attributes' => [
                'resource_information' => $resourceIdentifier,
            ],
            'relationships' => [
                'slate_addon_integrations' => [
                    'data' => [
                        'type' => EntityType::SLATE_ADDON_INTEGRATION,
                        'id' => $slateAddonIntegrationId
                    ]
                ],
                'organizations' => [
                    'data' => [
                        'type' => EntityType::ORGANIZATION,
                        'id' => $organizationId
                    ]
                ]
            ]
        ];

        parent::__construct($data);
    }
}
