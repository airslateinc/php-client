<?php

namespace AirSlate\ApiClient\Models\OrganizationAddon;

use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    private $addonId;

    public function toArray(): array
    {
        return [
            'data' => [
                'type' => 'organization_addons',
                'relationships' => [
                    'addon' => [
                        'data' => [
                            'type' => 'addons',
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
