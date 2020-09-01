<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
{
    /**
     * @param array $resourceIdentifier
     * @param array $searchParameters
     * @param array $rows
     * @param string $slateAddonIntegrationId
     * @param string $organizationId
     */
    public function __construct(
        array $resourceIdentifier,
        array $searchParameters,
        array $rows,
        string $slateAddonIntegrationId,
        string $organizationId
    ) {
        $data = [
            'type' => 'data_update_request',
            'attributes' => [
                'resource_information' => $resourceIdentifier,
                'search_parameters' => $searchParameters,
                'rows' => $rows,
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
