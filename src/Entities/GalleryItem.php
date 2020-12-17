<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Class GalleryItem
 * @package AirSlate\ApiClient\Entities
 * @property string $id
 * @property string $type
 * @property string $subtype
 * @property string $author_uid
 * @property bool $is_default
 * @property string $meta
 * @property-read File|null $file
 */
class GalleryItem extends BaseEntity
{
    protected $type = EntityType::GALLERY_ITEMS;

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->hasOne(File::class, 'file');
    }
}
