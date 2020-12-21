<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Exceptions;

use Throwable;

class IncorrectValueForEnum extends DomainException
{
    /** @const string */
    private const DEFAULT_MESSAGE_FORMATTER = "Your value is incorrect '%s', possible values: %s.";

    /**
     * @param string $value
     * @param array $possibleValues
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $value, array $possibleValues, int $code = 0, Throwable $previous = null)
    {
        $message = sprintf(self::DEFAULT_MESSAGE_FORMATTER, $value, implode(',', $possibleValues));

        parent::__construct($message, $code, $previous);
    }
}
