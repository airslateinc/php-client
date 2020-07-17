<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Role;

use AirSlate\ApiClient\Entities\EntityType;
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
            'type' => EntityType::FLOW_ROLE,
            'attributes' => [
                'name' => $name
            ],
            'relationships' => [
                'flow' => [
                    'data' => [
                        'type' => EntityType::SLATE,
                        'id' => $slateId
                    ]
                ]
            ]
        ];
    }
}
