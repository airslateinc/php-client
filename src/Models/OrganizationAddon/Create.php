<?php

namespace AirSlate\ApiClient\Models\OrganizationAddon;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    private $addonId;

    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::ORGANIZATION_ADDON,
                'relationships' => [
                    'addon' => [
                        'data' => [
                            'type' => EntityType::ADDON,
                            'id' => $this->addonId
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function fromAddonId(string $addonId): Create
    {
        $model = new self();
        $model->addonId = $addonId;

        return $model;
    }
}
