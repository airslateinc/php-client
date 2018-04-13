<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Document
 * @package AirSlate\ApiClient\Models
 *
 * @method addPages(string $id): Document
 * @method addAttributes(string $id): Document
 * @method addContent(string $id): Document
 * @method addFields(string $id): Document
 * @method addRoles(string $id): Document
 * @method addComments(string $id): Document
 * @method addOriginal(string $id): Document
 * @method addImage(string $id): Document
 * @method addPdf(string $id): Document
 * @method setName(string $name): Document
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
    ];

    /**
     * @var string
     */
    private $name = 'Default Document Name';

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     */
    public function __call(string $name, array $arguments): Create
    {
        if ($name === 'setName') {
            $this->name = (string)$arguments[0];
            return $this;
        }
        if (!array_key_exists($name, $this->methodToField)) {
            throw new \InvalidArgumentException(sprintf('Method %s not allowed', $name));
        }
        $this->data[$this->methodToField[$name]] = [
            'data' => [
                'type' => 'files',
                'id' => (string) $arguments[0],
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
                'type' => 'documents',
                'attributes' => [
                    'name' => $this->name,
                ],
                'relationships' => $this->data,
            ]
        ];
    }
}
