<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Gallery;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class AddGalleryItem extends AbstractModel
{
    public function addGalleryItem(string $category, string $type, string $fileUid, bool $isDefault, array $meta = [])
    {
        $this->data = [
            'type' => EntityType::GALLERY_ITEMS,
            'attributes' => [
                'type' => $category,
                'subtype' => $type,
                'meta' => $meta,
                'is_default' => $isDefault
            ],
            'relationships' => [
                'file' => [
                    'data' => [
                        'type' => EntityType::FILE,
                        'id' => $fileUid,
                    ]
                ]
            ]
        ];
    }
}
