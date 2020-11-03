<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\CloudStorage;

use AirSlate\ApiClient\DTO\CloudStorage\Entity;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
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
            'id' => '4AC10000-0000-0000-0000ED29', // encoded 0
            'type' => 'data_update_request',
            'attributes' => [
                'resource_information' => $resourceInformation,
                'entity_type' => $entityType,
                'search_parameters' => [],
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
