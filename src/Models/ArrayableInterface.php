<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models;

/**
 * @package AirSlate\ApiClient\Models
 */
interface ArrayableInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}
