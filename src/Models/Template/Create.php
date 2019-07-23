<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Template;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Template
 * @package AirSlate\ApiClient\Models
 */
class Create extends AbstractModel
{
    /**
     * @param string $documentId
     */
    public function addDocument(string $documentId)
    {
        if (!isset($this->data['documents']['data'])) {
            $this->data['documents']['data'] = [];
        }

        $this->data['documents']['data'][] = [
            'type' => EntityType::DOCUMENT,
            'id' => $documentId,
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::TEMPLATE,
                'relationships' => $this->data,
            ]
        ];
    }
}
