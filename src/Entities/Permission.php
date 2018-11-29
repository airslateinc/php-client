<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Class Permission
 *
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $is_top
 */
class Permission extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'permissions';
}
