<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Contracts\Services;

interface AsyncService
{
    /** @const int */
    public const DEFAULT_CONCURRENCY = 10;
}
