<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Create
 * @package AirSlate\ApiClient\Models\Document
 *
 * @method addPages(string $id): Create
 * @method addAttributes(string $id): Create
 * @method addContent(string $id): Create
 * @method addFields(string $id): Create
 * @method addRoles(string $id): Create
 * @method addComments(string $id): Create
 * @method addOriginal(string $id): Create
 * @method addImage(string $id): Create
 * @method addPdf(string $id): Create
 * @method addFinalPdf(string $id): Create
 */
class Create extends AbstractModel
{
    private $methodToField = [
        'addPages' => 'pages_file',
        'addAttributes' => 'attributes_file',
        'addContent' => 'content_file',
        'addFields' => 'fields_file',
        'addRoles' => 'roles_file',
        'addComments' => 'comments_file',
        'addOriginal' => 'original_file',
        'addImage' => 'image_file',
        'addPdf' => 'pdf_file',
        'addFinalPdf' => 'final_pdf_file',
    ];

    /**
     * @var string
     */
    private $name = 'Default Document Name';

    /**
     * @var int
     */
    private $pagesCount = 0;

    /**
     * @var int
     */
    private $visiblePagesCount = 0;

    /**
     * @var string
     */
    private $type = 'PDF';

    /**
     * @var string
     */
    private $editorType = 'PDF';

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function __call(string $name, array $arguments): Create
    {
        if (!array_key_exists($name, $this->methodToField)) {
            throw new \InvalidArgumentException(sprintf('Method %s not allowed', $name));
        }
        $this->data[$this->methodToField[$name]] = [
            'data' => [
                'type' => EntityType::FILE,
                'id' => (string)$arguments[0],
            ]
        ];
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::DOCUMENT,
                'attributes' => [
                    'name' => $this->name,
                    'type' => $this->type,
                    'editor_type' => $this->editorType,
                ],
                'meta' => [
                    'num_pages' => $this->pagesCount,
                    'num_visible_pages' => $this->visiblePagesCount,
                ],
                'relationships' => $this->data,
            ]
        ];
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
    public function setEditorType (string $editorType): Create
    {
        $this->editorType = $editorType;
        return $this;
    }
}
