<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\File;

use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Bulk
 * @package AirSlate\ApiClient\Models
 *
 */
class Bulk extends AbstractModel
{
    /**
     * @param $name
     * @param $content
     */
    public function addFile(string $name, string $content): void
    {
        $this->data[] = [
            'type' => 'files',
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
            'data' => [
                'type' => 'files',
                'attributes' => [
                    'name' => $name,
                    'url' => $url,
                ]
            ]
        ];
    }
}
