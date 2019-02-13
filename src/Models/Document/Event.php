<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Models\AbstractModel;

class Event extends AbstractModel
{
    /**
     * @param string $event
     */
    public function setData(string $event): void
    {
        $this->data = [
            'type' => 'events',
            'attributes' => [
                'name' => $event,
            ],
        ];
    }

    /**
     * @param string $type
     * @return Event
     */
    public static function createFromType(string $type): self
    {
        $event = new static();
        $event->setData($type);
        return $event;
    }
}
