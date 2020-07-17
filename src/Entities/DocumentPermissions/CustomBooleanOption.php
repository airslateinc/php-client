<?php

declare(strict_types=1);

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

    /**
     * @param bool $value
     * @param bool $override
     */
    public function __construct(bool $value = false, bool $override = false)
    {
        $this->value = $value;
        $this->override = $override;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setValue(bool $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param bool $override
     * @return $this
     */
    public function setOverride(bool $override): self
    {
        $this->override = $override;

        return $this;
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function getOverride(): bool
    {
        return $this->override;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'override' => $this->override
        ];
    }
}
