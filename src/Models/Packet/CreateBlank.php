<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class CreateBlank
 * @package AirSlate\ApiClient\Models
 *
 */
class CreateBlank extends AbstractModel
{
    /** @var string */
    private $name;

    /** @var array  */
    private $additionalData = [];

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param array $additionalData
     */
    public function setAdditionalData(array $additionalData): void
    {
        $this->additionalData = $additionalData;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::PACKET,
                'attributes' => [
                    'name' => $this->name,
                    'additional_data' => $this->additionalData
                ]
            ],
        ];
    }
}
