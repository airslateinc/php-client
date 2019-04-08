<?php

namespace AirSlate\ApiClient\Models\RoleDocument;

use AirSlate\ApiClient\Models\AbstractModel;

class Delete extends AbstractModel
{
    /**
     * @param string $roleDocumentId
     */
    public function addRoleDocument(string $roleDocumentId): void
    {
        $this->data[] = [
            'type' => 'flow_role_documents',
            'id'   => $roleDocumentId
        ];
    }
}