<?php
declare(strict_types = 1);

namespace AirSlate\ApiClient\Entities\DocumentPermissions;

abstract class CustomBooleanOption
{
    /**
     * @var bool
     */
    private $value;

    /**
     * @var bool
     */
    private $override;

    public function __construct(bool $value = false, bool $override = false)
    {
        $this->value = $value;
        $this->override = $override;
    }

    public function setValue(bool $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setOverride(bool $override): self
    {
        $this->override = $override;

        return $this;
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function getOverride(): bool
    {
        return $this->override;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'override' => $this->override
        ];
    }
}
