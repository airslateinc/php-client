<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models;

use AirSlate\ApiClient\Entities\Field;

/**
 * @package AirSlate\ApiClient\Models
 */
abstract class AbstractModel
{
    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
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
