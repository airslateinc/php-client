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

    /**
     * @var string
     */
    protected $slateAddonId;

    public function toArray(): array
    {
        return [
            'type' => 'slate_addons_messages',
            'attributes' => $this->attributes,
        ];
    }

    /**
     * @return string
     */
    public function getSlateAddonId(): string
    {
        return $this->slateAddonId ?? '';
    }

    /**
     * @param string $slateAddonId
     * @param array $attributes
     * @return Create
     */
    public static function fromAttributes(string $slateAddonId, array $attributes): self
    {
        $model = new self();
        $model->slateAddonId = $slateAddonId;
        $model->attributes = $attributes;

        return $model;
    }
}
