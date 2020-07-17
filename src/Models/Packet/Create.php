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
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::PACKET,
            ],
        ];
    }
}
