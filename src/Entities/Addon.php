<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class Addon
 *
 * @property string $id
 * @property string $name
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package AirSlate\ApiClient\Entities
 */
class Addon extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::ADDON;
}
