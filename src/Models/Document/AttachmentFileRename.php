<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * @package AirSlate\ApiClient\Models\Document
 */
class AttachmentFileRename extends AbstractModel
{
    /** @var string */
    protected $type = EntityType::DOCUMENT_ATTACHMENT;

    /** @var string */
    private $name;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => $this->type,
                'attributes' => [
                    'name' => $this->name,
                ],
            ],
        ];
    }
}
