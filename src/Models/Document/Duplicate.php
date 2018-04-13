<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Duplicate
 * @package AirSlate\ApiClient\Models\Document
 */
class Duplicate extends AbstractModel
{
    /**
     * @param string $id
     */
    public function addDocument(string $id): void
    {
        $this->data[] = [
            'id' => $id,
            'type' => 'documents',
        ];
    }
}
