<?php

namespace AirSlate\ApiClient\Models\Role;

use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    /**
     * @param string $name
     * @param string $slateId
     */
    public function addRole(string $name, string $slateId): void
    {
        $this->data[] = [
            'type' => 'flow_roles',
            'attributes' => [
                'name' => $name
            ],
            'relationships' => [
                'flow' => [
                    'data' => [
                        'type' => 'slates',
                        'id' => $slateId
                    ]
                ]
            ]
        ];
    }
}