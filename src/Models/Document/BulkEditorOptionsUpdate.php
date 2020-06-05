<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * @package AirSlate\ApiClient\Models\Document
 */
class BulkEditorOptionsUpdate extends AbstractModel
{
    /** @var string */
    protected $type = EntityType::EDITOR_OPTIONS;

    /** @var array */
    private $documentsEditorOptions;

    /**
     * @param EditorOptionsUpdate $editorOptionsUpdate
     */
    public function addDocumentEditorOptions(EditorOptionsUpdate $editorOptionsUpdate): void
    {
        $this->documentsEditorOptions[] = $editorOptionsUpdate;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => array_map(function (EditorOptionsUpdate $optionsUpdate) {
                return $optionsUpdate->toArray()['data'];
            }, $this->documentsEditorOptions)
        ];
    }
}
