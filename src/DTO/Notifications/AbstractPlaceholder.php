<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\DTO\Notifications;

use AirSlate\ApiClient\Models\ArrayableInterface;

abstract class AbstractPlaceholder implements ArrayableInterface
{
    /** @var string */
    protected $name;

    /** @var array */
    protected $data;

    /**
     * @param string $name
     * @param string $type
     */
    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->data = [
            'placeholder_type' => $type,
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
