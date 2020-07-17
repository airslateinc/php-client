<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Role;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Delete extends AbstractModel
{
    /**
     * @param string $roleId
     */
    public function addRole(string $roleId): void
    {
        $this->data[] = [
            'type' => EntityType::FLOW_ROLE,
            'id'   => $roleId
        ];
    }
}
