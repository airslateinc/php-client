<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\DTO\Notifications;

class TextPlaceholder extends AbstractPlaceholder
{
    /** @var string */
    private const TYPE = 'text';

    /**
     * @param string $name
     * @param string $value
     */
    public function __construct(string $name, string $value)
    {
        parent::__construct($name, self::TYPE);

        $this->data['text'] = $value;
    }
}
