<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\StorageFile;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Upload
 *
 * @package AirSlate\ApiClient\Models\StorageFile
 */
class Upload extends AbstractModel
{
    /**
     * Upload constructor.
     *
     * @param string $name
     * @param string $file
     * @param int|null $ttl
     */
    public function __construct(string $name, string $file, ?int $ttl = null)
    {
        $data = [
            'attributes' => [
                'name' => $name,
                'file' => $file,
            ]
        ];

        if (!is_null($ttl)) {
            $data['attributes']['ttl'] = $ttl;
        }

        parent::__construct($data);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::STORAGE_FILE,
                'attributes' => $this->data['attributes'],
            ]
        ];
    }
}
