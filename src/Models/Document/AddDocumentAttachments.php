<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

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
            'type' => 'document_attachments',
            'attributes' => [
                'type' => $category,
                'subtype' => $type,
                'meta' => $meta
            ],
            'relationships' => [
                'file' => [
                    'data' => [
                        'type' => 'files',
                        'id' => $fileUid,
                    ]
                ]
            ]
        ];
    }
}
