<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Exceptions;

use Throwable;

final class ForbiddenException extends DomainException
{
    /** @const string  */
    private const MESSAGE = "You don't have permission for this endpoint";

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = self::MESSAGE, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
