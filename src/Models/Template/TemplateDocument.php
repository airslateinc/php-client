<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Template;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class TemplateDocument
 * @package AirSlate\ApiClient\Models\Template
 */
class TemplateDocument extends AbstractModel
{
    /**
     * TemplateDocument constructor.
     * @param string $documentId
     */
    public function __construct(string $documentId)
    {
        $data = [
            'id' => $documentId,
            'type' => EntityType::DOCUMENT
        ];
        parent::__construct($data);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => $this->data
        ];
    }
}
