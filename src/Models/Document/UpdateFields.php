<?php

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\Field;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class UpdateFields
 * @package AirSlate\ApiClient\Models\Document
 */
class UpdateFields extends AbstractModel
{
    /**
     * UpdateFields constructor.
     * @param Field[] $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $datum) {
            if (!$datum instanceof Field) {
                throw new \InvalidArgumentException("Invalid type provided for item. Instance of Field expected.");
            }
        }
        
        parent::__construct($data);
    }
    
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => array_map(function(Field $field) {
                return $field->jsonSerialize()['data'];
            }, $this->data),
        ];
    }
}
