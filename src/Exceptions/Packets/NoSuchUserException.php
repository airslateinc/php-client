<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Exceptions\Packets;

use AirSlate\ApiClient\Exceptions\DomainException;

class NoSuchUserException extends DomainException
{
    /**
     * @return string
     */
    protected function retrieveMessage(): string
    {
        return 'There is no such user in the system';
    }
}
