<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Export
 *
 * @package AirSlate\ApiClient\Models\Document
 */
class Export extends AbstractModel
{
    /**
     * @param string $id
     */
    public function addDocument(string $id): void
    {
        $this->data[] = [
            'id' => $id,
            'type' => EntityType::DOCUMENT,
        ];
    }
}
