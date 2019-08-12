<?php

namespace AirSlate\ApiClient\Models\SlateAddon;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    protected $attributes;

    protected $slateId;

    protected $organizationAddonId;

    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::SLATE_ADDON,
                'attributes' => $this->attributes,
                'relationships' => [
                    'slate' => [
                        'data' => [
                            'id' => $this->slateId,
                            'type' => EntityType::SLATE
                        ]
                    ],
                    'organization_addon' => [
                        'data' => [
                            'id' => $this->organizationAddonId,
                            'type' => EntityType::ORGANIZATION_ADDON
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function fromAttributes(string $slateId, string $organizationAddonId, array $attributes)
    {
        $model = new static();
        $model->slateId = $slateId;
        $model->organizationAddonId = $organizationAddonId;
        $model->attributes = $attributes;

        return $model;
    }
}
