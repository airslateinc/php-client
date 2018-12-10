<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\Document;

/**
 * Class Update
 * @package AirSlate\ApiClient\Models\Document
 */
class Update extends Create
{
    /**
     * @var string
     */
    public $documentId;

    public function __construct(Document $document, $data)
    {
        $this->setName($document->getAttribute('name'));
        $this->setPagesCount($document->getObjectMetaAttribute('num_pages'));
        $this->setPagesCount($document->getObjectMetaAttribute('num_visible_pages'));
        $this->setDocumentId($document->id);

        parent::__construct($data);
    }

    /**
     * @param string $documentId
     * @return $this
     */
    public function setDocumentId(string $documentId)
    {
        $this->documentId = $documentId;
        return $this;
    }
}
