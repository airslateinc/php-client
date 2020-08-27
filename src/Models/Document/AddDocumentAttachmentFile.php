<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class AddDocumentAttachmentFile extends AbstractModel
{
    /**
     * @param string $category
     * @param string $type
     * @param string $name
     * @param string $file
     * @param array $meta
     */
    public function addDocumentAttachmentFile(
        string $category,
        string $type,
        string $name,
        string $file,
        array $meta = []
    ) {
        $this->data = [
            'type' => EntityType::DOCUMENT_ATTACHMENT,
            'attributes' => [
                'type' => $category,
                'subtype' => $type,
                'file' => base64_encode($file),
                'name' => $name,
                'meta' => $meta
            ],
        ];
    }
}
