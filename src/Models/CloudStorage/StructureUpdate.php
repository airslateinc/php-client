<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class StructureUpdate extends AbstractModel
{
    /**
     * @param array $resourceInformation
     * @param array $structureChanges
     * @param string $slateAddonIntegrationId
     * @param string $organizationId
     */
    public function __construct(
        array $resourceInformation,
        array $structureChanges,
        string $slateAddonIntegrationId,
        string $organizationId
    ) {
        $data = [
            'id' => '52650000-0000-0000-000062FD', // encoded 0
            'type' => 'structure_update_request',
            'attributes' => [
                'resource_information' => $resourceInformation,
                'structure_changes' => $structureChanges,
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
