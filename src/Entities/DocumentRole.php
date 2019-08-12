<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class Role
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $title
 * @property int $required_fields
 * @property int $fillable_fields
 */

class DocumentRole extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::DOCUMENT_ROLE;
}
