<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Class Tag
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class Tag extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::FLOW_TAG;
}
