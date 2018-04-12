<?php

namespace AirSlate\ApiClient\Exceptions;

/**
 * Class MissingDataException
 * @package AirSlate\ApiClient\Exceptions
 */
class MissingDataException extends DomainException
{
    /**
     * @return string
     */
    protected function retrieveMessage(): string
    {
        return 'Data is missing in json api response.';
    }
}
