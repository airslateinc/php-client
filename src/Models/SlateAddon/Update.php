<?php

namespace AirSlate\ApiClient\Models\SlateAddon;

use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
{
    protected $id;

    protected $attributes;

    protected $slateId;

    protected $organizationAddonId;

    public function toArray(): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'type' => 'slate_addons',
                'attributes' => $this->attributes,
                'relationships' => [
                    'slate' => [
                        'data' => [
                            'id' => $this->slateId,
                            'type' => 'slates'
                        ]
                    ],
                    'organization_addon' => [
                        'data' => [
                            'id' => $this->organizationAddonId,
                            'type' => 'organization_addons'
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function fromAttributes(
        string $id,
        string $slateId,
        string $organizationAddonId,
        array $attributes
    ): self {
        $model = new self();
        $model->id = $id;
        $model->slateId = $slateId;
        $model->organizationAddonId = $organizationAddonId;
        $model->attributes = $attributes;

        return $model;
    }
}
