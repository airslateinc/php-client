<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Exceptions\Users;

use RuntimeException;

final class UnauthorizedClient extends RuntimeException
{
    protected $message = 'Client is not authorized';
}
