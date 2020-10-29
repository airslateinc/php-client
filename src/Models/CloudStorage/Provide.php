<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Provide extends AbstractModel
{
    /**
     * @param array $resourceIdentifier
     * @param string $entityType
     * @param string $slateAddonIntegrationId
     * @param string $organizationId
     */
    public function __construct(
        array $resourceIdentifier,
        string $entityType,
        string $slateAddonIntegrationId,
        string $organizationId
    ) {
        $data = [
            'id' => '87AB0000-0000-0000-0000A55C', // encoded 0
            'type' => 'data_provide_request',
            'attributes' => [
                'resource_information' => $resourceIdentifier,
                'entity_type' => $entityType,
                'search_parameters' => [],
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

    /**
     * @param string $attribute
     * @param string[] $inArray
     * @return $this
     */
    public function addSearchParameter(string $attribute, array $inArray): self
    {
        $this->data['attributes']['search_parameters'][] = [
            'attribute' => $attribute,
            'in_array' => $inArray,
        ];

        return $this;
    }
}
