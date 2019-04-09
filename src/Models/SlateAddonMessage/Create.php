<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\SlateAddonMessage;

use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    /**
     * @var array
     */
    protected $attributes;

    public function toArray(): array
    {
        return [
            'type' => 'slate_addon_messages',
            'attributes' => $this->attributes,
        ];
    }

    /**
     * @param array $attributes
     * @return Create
     */
    public static function fromAttributes(array $attributes): self
    {
        $model = new self();
        $model->attributes = $attributes;

        return $model;
    }
}
