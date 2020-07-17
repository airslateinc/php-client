<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Slate;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Models
 *
 */
class Create extends AbstractModel
{
    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->data['name'] = $name;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->data['description'] = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::SLATE,
                'attributes' => [
                    'name' => $this->data['name'] ?? '',
                    'description' => $this->data['description'] ?? '',
                ],
            ]
        ];
    }
}
