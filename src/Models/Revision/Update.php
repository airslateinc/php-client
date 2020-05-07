<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Revision;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * @package AirSlate\ApiClient\Models\Revision
 */
class Update extends AbstractModel
{
    /** @var string */
    protected $uid;

    /** @var array */
    protected $attributes;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'id' => $this->uid,
                'type' => EntityType::PACKET_REVISION,
                'attributes' => $this->attributes,
            ]
        ];
    }

    /**
     * @param string $uid
     * @param array $attributes
     * @return Update|static
     */
    public static function fromAttributes(string $uid, array $attributes): self
    {
        $model = new self();
        $model->uid = $uid;
        $model->attributes = $attributes;

        return $model;
    }
}
