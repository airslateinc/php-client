<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class DocumentFiles
 * @package AirSlate\ApiClient\Models\Document
 */
class DocumentFiles extends AbstractModel
{
    /**
     * @param string $type
     * @param string $name
     * @param string $content
     */
    public function addFile(string $type, string $name, string $content): void
    {
        if (!in_array($type, Document::DOCUMENT_FILES)) {
            throw new \InvalidArgumentException(sprintf('Unsupported document file type: %s', $type));
        }

        $this->data[] = [
            'type' => $type,
            'attributes' => [
                'name' => $name,
                'file' => base64_encode($content),
            ]
        ];
    }
}
