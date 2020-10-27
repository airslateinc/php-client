<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Helpers;

/**
 * Class ExperimentGuestIdGenerator
 * @package App\Services\Experiments\Helpers
 */
class ExperimentGuestIdGenerator
{
    public static function generate(): string
    {
        return sprintf('%s.%d', substr(md5(rand() . uniqid()), 0, 10), time());
    }
}
