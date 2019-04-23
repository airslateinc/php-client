<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Exceptions\Packets;

use AirSlate\ApiClient\Exceptions\DomainException;

class UserHasNoAccessException extends DomainException
{
    /**
     * @return string
     */
    protected function retrieveMessage(): string
    {
        return 'User has no access to the revision.';
    }
}
