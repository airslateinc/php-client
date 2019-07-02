<?php

namespace AirSlate\ApiClient\Entities\EventBus;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * Class Event
 *
 * @property string $id
 * @property string $routing_key
 * @property array $payload
 *
 * @package AirSlate\ApiClient\Entities
 */
class Event extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::APPLICATION_MESSAGE_BUS_EVENT;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'attributes' => [
                'routing_key' => $this->routing_key,
                'payload' => $this->payload,
            ],
        ];
    }
}
