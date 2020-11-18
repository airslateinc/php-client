<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\ExportZip;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    public function __construct(array $data = [])
    {
        $data = array_merge_recursive(
            [
                'type' => EntityType::EXPORT,
                'attributes' => [
                    'files' => [],
                ],
            ],
            $data
        );

        parent::__construct($data);
    }

    public function addFile(string $name, string $downloadUrl, string $path = ''): self
    {
        $this->data['attributes'][] = [
            'name' => $name,
            'path' => $path,
            'url' => $downloadUrl
        ];

        return $this;
    }
}
