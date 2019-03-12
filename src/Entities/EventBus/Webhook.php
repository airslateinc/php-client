<?php

namespace AirSlate\ApiClient\Entities\EventBus;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * Class Webhook
 *
 * @property string $id
 * @property string $routing_key
 * @property string $callback_url
 *
 * @package AirSlate\ApiClient\Entities
 */
class Webhook extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::APPLICATIONS_CALLBACK;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'attributes' => [
                'routing_key' => $this->routing_key,
                'callback_url' => $this->callback_url,
            ],
        ];
    }
}
