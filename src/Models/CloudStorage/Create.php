<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage;

use AirSlate\ApiClient\DTO\CloudStorage\Entity;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
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
            'type' => 'data_create_request',
            'attributes' => [
                'resource_information' => $resourceInformation,
                'entity_type' => $entityType,
                'entities' => [],
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
     * @param Entity $entity
     * @return $this
     */
    public function addEntity(Entity $entity): self
    {
        $this->data['attributes']['entities'][] = $entity->toArray();

        return $this;
    }
}
