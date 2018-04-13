<?php

namespace AirSlate\ApiClient\Exceptions;

/**
 * Class TypeMismatchException
 * @package AirSlate\ApiClient\Exceptions
 */
class TypeMismatchException extends DomainException
{
    /**
     * @return string
     */
    protected function retrieveMessage(): string
    {
        return 'Json type does not match to the entity type.';
    }
}
