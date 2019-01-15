<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\RevisionDocument;

use AirSlate\ApiClient\Models\AbstractModel;

class BulkUpdate extends AbstractModel
{
    public function addRevisionDocument(string $revisionDocumentUid, array $attributes = [])
    {
        $this->data[] = [
            'id' => $revisionDocumentUid,
            'type' => 'packet_revision_documents',
            'attributes' => $attributes,
        ];
    }
}
