<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\RoleDocument;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Delete extends AbstractModel
{
    /**
     * @param string $roleDocumentId
     */
    public function addRoleDocument(string $roleDocumentId): void
    {
        $this->data[] = [
            'type' => EntityType::FLOW_ROLE_DOCUMENT,
            'id'   => $roleDocumentId
        ];
    }
}
