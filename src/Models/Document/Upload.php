<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

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
            'type' => 'files',
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
            'type' => 'files',
            'attributes' => [
                'name' => $filename,
                'url'  => $url,
            ]
        ];
    }

}
