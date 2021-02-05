<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Models
 *
 */
class Create extends AbstractModel
{
    /** @var string */
    private $name;

    /**
     * @param string $name
     * @return Create
     */
    public function setName(string $name): Create
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'data' => [
                'type' => EntityType::PACKET,
            ],
        ];

        if (isset($this->name)) {
            $data['data']['attributes']['name'] = $this->name;
        }

        return $data;
    }
}
