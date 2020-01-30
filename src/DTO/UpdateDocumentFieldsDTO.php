<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\DTO;

use AirSlate\ApiClient\Models\Document\UpdateFields;

class UpdateDocumentFieldsDTO
{
    /** @var string */
    private $documentUid;

    /** @var UpdateFields */
    private $fields;

    /**
     * @return string
     */
    public function getDocumentUid(): string
    {
        return $this->documentUid;
    }

    /**
     * @param string $documentUid
     * @return UpdateDocumentFieldsDTO
     */
    public function setDocumentUid(string $documentUid): UpdateDocumentFieldsDTO
    {
        $this->documentUid = $documentUid;

        return $this;
    }

    /**
     * @return UpdateFields
     */
    public function getFields(): UpdateFields
    {
        return $this->fields;
    }

    /**
     * @param UpdateFields $fields
     * @return UpdateDocumentFieldsDTO
     */
    public function setFields(UpdateFields $fields): UpdateDocumentFieldsDTO
    {
        $this->fields = $fields;

        return $this;
    }
}
