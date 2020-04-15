<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Class StorageFile
 *
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $author_id
 * @property string $name
 * @property int $size
 * @property string $md5_content
 * @property string $content_type
 * @property string $created_at
 * @property string $updated_at
 * @property string $expires_at
 */
class StorageFile extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::STORAGE_FILE;
}
