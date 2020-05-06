<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Create
 * @package AirSlate\ApiClient\Models\Document
 */
class Create extends AbstractModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $pagesCount;

    /**
     * @var int
     */
    private $visiblePagesCount;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $editorType;

    /**
     * @var bool
     */
    private $hideStamps;

    /**
     * @param string $layer
     * @param string $id
     */
    private function addRelationshipLayer(string $layer, string $id): void
    {
        $this->data['relationships'][$layer] = [
            'data' => [
                'type' => EntityType::FILE,
                'id' => $id,
            ]
        ];
    }

    /**
     * @param string $id
     * @return Create
     */
    public function addPages(string $id): Create
    {
        $this->addRelationshipLayer('pages_file', $id);
        return $this;
    }

    /**
     * @param string $id
     * @return Create
     */
    public function addAttributes(string $id): Create
    {
        $this->addRelationshipLayer('attributes_file', $id);
        return $this;
    }

    /**
     * @param string $id
     * @return Create
     */
    public function addContent(string $id): Create
    {
        $this->addRelationshipLayer('content_file', $id);
        return $this;
    }

    /**
     * @param string $id
     * @return Create
     */
    public function addFields(string $id): Create
    {
        $this->addRelationshipLayer('fields_file', $id);

        return $this;
    }

    /**
     * @param string $id
     * @return Create
     */
    public function addOriginal(string $id): Create
    {
        $this->addRelationshipLayer('original_file', $id);
        return $this;
    }

    /**
     * @param string $id
     * @return Create
     */
    public function addImage(string $id): Create
    {
        $this->addRelationshipLayer('image_file', $id);
        return $this;
    }

    /**
     * @param string $id
     * @return Create
     */
    public function addPdf(string $id): Create
    {
        $this->addRelationshipLayer('pdf_file', $id);
        return $this;
    }

    /**
     * @param string $id
     * @return Create
     */
    public function addFinalPdf(string $id): Create
    {
        $this->addRelationshipLayer('final_pdf_file', $id);
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $payload = [
            'data' => $this->data,
        ];
        $payload['data']['type'] = EntityType::DOCUMENT;

        //attributes
        if (!empty($this->name)) {
            $payload['data']['attributes']['name'] = $this->name;
        }
        if (!empty($this->type)) {
            $payload['data']['attributes']['type'] = $this->type;
        }
        if (!empty($this->editorType)) {
            $payload['data']['attributes']['editor_type'] = $this->editorType;
        }
        if (($this->hideStamps === true) || ($this->hideStamps === false)) {
            $payload['data']['attributes']['properties']['hide_stamps'] = $this->hideStamps;
        }

        //meta
        if ($this->pagesCount != null) {
            $payload['data']['meta']['num_pages'] = $this->pagesCount;
        }
        if ($this->visiblePagesCount != null) {
            $payload['data']['meta']['num_visible_pages'] = $this->visiblePagesCount;
        }

        //included
        if (!empty($this->included)) {
            $payload['included'] = $this->included;
        }

        return $payload;
    }

    /**
     * @param string $name
     * @return Create|static
     */
    public function setName(string $name): Create
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $pagesCount
     * @return Create|static
     */
    public function setPagesCount(int $pagesCount): Create
    {
        $this->pagesCount = $pagesCount;

        return $this;
    }

    /**
     * @param int $pagesCount
     * @return Create|static
     */
    public function setVisiblePagesCount(int $pagesCount): Create
    {
        $this->visiblePagesCount = $pagesCount;

        return $this;
    }

    /**
     * @param string $type
     * @return Create
     */
    public function setType(string $type): Create
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $editorType
     * @return Create
     */
    public function setEditorType(string $editorType): Create
    {
        $this->editorType = $editorType;

        return $this;
    }

    /**
     * @param bool $hideStamps
     * @return Create|static
     */
    public function setHideStamps(bool $hideStamps): Create
    {
        $this->hideStamps = $hideStamps;

        return $this;
    }
}
