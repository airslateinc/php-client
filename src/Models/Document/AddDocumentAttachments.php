<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class AddDocumentAttachments extends AbstractModel
{
    /**
     * @param string $category
     * @param string $type
     * @param string $fileUid
     * @param array $meta
     */
    public function addDocumentAttachments(string $category, string $type, string $fileUid, array $meta = [])
    {
        $this->data = [
            'type' => EntityType::DOCUMENT_ATTACHMENT,
            'attributes' => [
                'type' => $category,
                'subtype' => $type,
                'meta' => $meta
            ],
            'relationships' => [
                'file' => [
                    'data' => [
                        'type' => EntityType::FILE,
                        'id' => $fileUid,
                    ]
                ]
            ]
        ];
    }
}
