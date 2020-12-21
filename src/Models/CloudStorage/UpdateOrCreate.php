<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage;

use AirSlate\ApiClient\DTO\CloudStorage\Entity;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class UpdateOrCreate extends AbstractModel
{
    /**
     * @param array $resourceInformation
     * @param string $entityType
     * @param string $slateAddonIntegrationId
     * @param string $organizationId
     * @param Entity $entity
     */
    public function __construct(
        array $resourceInformation,
        string $entityType,
        string $slateAddonIntegrationId,
        string $organizationId,
        Entity $entity
    ) {
        $data = [
            'id' => 'CB1C0000-0000-0000-0000C267', // encoded 0
            'type' => 'data_update_or_create_request',
            'attributes' => [
                'resource_information' => $resourceInformation,
                'entity_type' => $entityType,
                'search_parameters' => [],
                'entity' => $entity->toArray(),
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
