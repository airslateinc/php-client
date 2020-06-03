<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Class Export
 *
 * @property string $id
 * @property string $name
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package AirSlate\ApiClient\Entities
 */
class Export extends BaseEntity
{
    /** @var string */
    protected $type = EntityType::EXPORT;
}
