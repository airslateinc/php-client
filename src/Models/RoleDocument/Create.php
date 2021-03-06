<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\RoleDocument;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    /**
     * @param string $flowRoleId
     * @param string $slateId
     * @param string $documentId
     * @param array $attributes
     */
    public function addRoleDocument(string $flowRoleId, string $slateId, string $documentId, array $attributes): void
    {
        $this->data[] = [
            'type' => EntityType::FLOW_ROLE_DOCUMENT,
            'attributes' => $attributes,
            'relationships' => [
                'role' => [
                    'data' => [
                        'type' => EntityType::FLOW_ROLE,
                        'id' => $flowRoleId
                    ]
                ],
                'flow' => [
                    'data' => [
                        'type' => EntityType::SLATE,
                        'id' => $slateId
                    ]
                ],
                'template_document' => [
                    'data' => [
                        'type' => EntityType::DOCUMENT,
                        'id' => $documentId
                    ]
                ]
            ]
        ];
    }
}
