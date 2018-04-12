<?php

namespace AirSlate\ApiClient\Exceptions;

use Throwable;

/**
 * Class DomainException
 * @package AirSlate\ApiClient\Exceptions
 */
class DomainException extends \DomainException
{
    /**
     * DomainException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: $this->retrieveMessage(), $code, $previous);
    }

    /**
     * @return string
     */
    protected function retrieveMessage(): string
    {
        return 'Something went wrong with AirSlate API.';
    }
}
