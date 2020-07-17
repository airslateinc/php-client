<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\RoleField;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Delete extends AbstractModel
{
    /**
     * @param string $roleFieldId
     */
    public function addRoleField(string $roleFieldId): void
    {
        $this->data[] = [
            'type' => EntityType::FLOW_ROLE_FIELD,
            'id'   => $roleFieldId
        ];
    }
}
