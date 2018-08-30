<?php

namespace AirSlate\ApiClient\Exceptions;

/**
 * Class RelationNotExistException
 * @package AirSlate\ApiClient\Exceptions
 */
class RelationNotExistException extends DomainException
{
    /**
     * @return string
     */
    protected function retrieveMessage(): string
    {
        return 'No relation with this name.';
    }
}
