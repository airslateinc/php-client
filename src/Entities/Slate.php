<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 */

class Slate extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'slates';
}
