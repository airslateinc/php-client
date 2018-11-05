<?php

namespace AirSlate\ApiClient\Entities\EventBus;

use AirSlate\ApiClient\Entities\BaseEntity;

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
    protected $type = 'applications-message-bus-event';

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
