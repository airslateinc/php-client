<?php

namespace AirSlate\ApiClient\Models\SlateAddon;

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

    public static function fromAttributes(string $slateId, string $organizationAddonId, array $attributes): self
    {
        $model = new self();
        $model->slateId = $slateId;
        $model->organizationAddonId = $organizationAddonId;
        $model->attributes = $attributes;

        return $model;
    }
}