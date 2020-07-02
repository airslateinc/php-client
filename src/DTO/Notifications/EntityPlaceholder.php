<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\DTO\Notifications;

class EntityPlaceholder extends AbstractPlaceholder
{
    /** @var string */
    private const TYPE = 'entity';

    /**
     * @param string $name
     * @param string $value
     * @param string $entityType
     * @param string $entityId
     */
    public function __construct(string $name, string $value, string $entityType, string $entityId)
    {
        parent::__construct($name, self::TYPE);

        $this->data['text'] = $value;
        $this->data['attributes'] = [
            'entity_type' => $entityType,
            'id' => $entityId,
        ];
    }
}
