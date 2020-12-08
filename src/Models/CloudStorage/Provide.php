<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Provide extends AbstractModel
{
    /**
     * @param array $resourceInformation
     * @param string $entityType
     * @param string $slateAddonIntegrationId
     * @param string $organizationId
     */
    public function __construct(
        array $resourceInformation,
        string $entityType,
        string $slateAddonIntegrationId,
        string $organizationId
    ) {
        $data = [
            'id' => '87AB0000-0000-0000-0000A55C', // encoded 0
            'type' => 'data_provide_request',
            'attributes' => [
                'resource_information' => $resourceInformation,
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
     * @param array $searchParameter
     * @return $this
     */
    public function addSearchParameter(array $searchParameter): self
    {
        $this->data['attributes']['search_parameters'][] = $searchParameter;

        return $this;
    }
}
