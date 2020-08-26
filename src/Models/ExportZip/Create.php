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
                'type' => EntityType::EXPORT_ZIP,
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
        $this->data['attributes']['files'][] = [
            'name' => $name,
            'path' => $path,
            'url' => $downloadUrl
        ];

        return $this;
    }

    public function setCallback(string $callback): self
    {
        $this->data['meta']['callback_url'] = $callback;

        return $this;
    }
}
