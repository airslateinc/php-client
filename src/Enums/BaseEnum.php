<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Enums;

use AirSlate\ApiClient\Exceptions\IncorrectValueForEnum;

abstract class BaseEnum
{
    /** @var string */
    private $value;

    /**
     * @param string $value
     * @throws IncorrectValueForEnum
     */
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @throws IncorrectValueForEnum
     */
    private function setValue(string $value): void
    {
        if (!in_array($value, $this->getPossibleValues())) {
            throw new IncorrectValueForEnum($value, $this->getPossibleValues());
        }

        $this->value = $value;
    }

    /**
     * @return array
     */
    abstract protected function getPossibleValues(): array;
}
