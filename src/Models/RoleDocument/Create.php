<?php

namespace AirSlate\ApiClient\Models\RoleDocument;

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
            'type' => 'flow_role_documents',
            'attributes' => $attributes,
            'relationships' => [
                'role' => [
                    'data' => [
                        'type' => 'flow_roles',
                        'id' => $flowRoleId
                    ]
                ],
                'flow' => [
                    'data' => [
                        'type' => 'slates',
                        'id' => $slateId
                    ]
                ],
                'template_document' => [
                    'data' => [
                        'type' => 'documents',
                        'id' => $documentId
                    ]
                ]
            ]
        ];
    }
}