<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\DTO\CloudStorage;

class Entity
{
    /** @var array */
    private $attributes = [];

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function addAttribute(string $name, $value): self
    {
        $this->attributes[] = [
            'name' => $name,
            'value' => $value,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'attributes' => $this->attributes,
        ];
    }
}
