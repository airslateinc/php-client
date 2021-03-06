<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Gallery;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class GalleryFile extends AbstractModel
{
    /**
     * @param $name
     * @param $content
     */
    public function addFile(string $name, string $content): void
    {
        $this->data = [
            'type' => EntityType::FILE,
            'attributes' => [
                'name' => $name,
                'file' => base64_encode($content),
            ]
        ];
    }

    /**
     * @param $name
     * @param $url
     */
    public function addUrl(string $name, string $url): void
    {
        $this->data[] = [
            'type' => EntityType::FILE,
            'attributes' => [
                'name' => $name,
                'url' => $url,
            ]
        ];
    }
}
