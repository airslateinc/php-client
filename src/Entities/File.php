<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class File
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $name
 * @property string $size
 * @property string $md5_content
 * @property string $content_type
 * @property string $created_at
 * @property string $updated_at
 *
 */

class File extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::FILE;
}
