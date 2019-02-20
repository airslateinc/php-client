<?php
declare(strict_types=1);


namespace AirSlate\ApiClient\Entities;

/**
 * Class Field
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $name
 * @property string|null $value
 * @property array $role_label
 */
class Field extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'dictionary';
}
