<?php

namespace AirSlate\ApiClient\Models\Role;

use AirSlate\ApiClient\Models\AbstractModel;

class Delete extends AbstractModel
{
    /**
     * @param string $roleId
     */
    public function addRole(string $roleId): void
    {
        $this->data[] = [
            'type' => 'flow_roles',
            'id'   => $roleId
        ];
    }
}