<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * @package AirSlate\ApiClient\Models\Document
 */
class EditorOptionsUpdate extends AbstractModel
{
    /** @var string */
    protected $type = EntityType::EDITOR_OPTIONS;

    /** @var string */
    private $documentUid;

    /** @var array */
    private $editorOptions;

    /**
     * @param string $documentUid
     */
    public function setDocumentUid(string $documentUid): void
    {
        $this->documentUid = $documentUid;
    }

    /**
     * @param string $option
     * @param mixed $optionValue
     * @param bool $override
     */
    public function setEditorOption(string $option, $optionValue, bool $override = false): void
    {
        $this->editorOptions[$option] = [
            'value' => $optionValue,
            'override' => $override
        ];
    }

    /**
     * @param array $options
     */
    public function setEditorOptions(array $options): void
    {
        $this->editorOptions = $options;
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
                    'editor_options' => $this->editorOptions,
                ],
                'relationships' => [
                    'documents' => [
                        'data' => [
                            'id' => $this->documentUid,
                            'type' => 'documents'
                        ],
                    ],
                ],
            ],
        ];
    }
}
