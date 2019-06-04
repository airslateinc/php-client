<?php
declare(strict_types = 1);

namespace AirSlate\ApiClient\Entities\DocumentPermissions;

abstract class CustomStringOption
{
    /**
     * @var bool
     */
    private $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function setValue(bool $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
        ];
    }
}
