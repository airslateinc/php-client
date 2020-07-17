<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Upload extends AbstractModel
{
    /**
     * Upload file
     * @param string $filename
     * @param string $fileContent
     */
    public function file(string $filename, string $fileContent): void
    {
        $this->data = [
            'type' => EntityType::FILE,
            'attributes' => [
                'name' => $filename,
                'file' => base64_encode($fileContent),
            ]
        ];
    }

    /**
     * Upload url
     * @param string $filename
     * @param string $url
     */
    public function url(string $filename, string $url): void
    {
        $this->data = [
            'type' => EntityType::FILE,
            'attributes' => [
                'name' => $filename,
                'url'  => $url,
            ]
        ];
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->data['attributes']['type'] = $type;

        return $this;
    }
}
