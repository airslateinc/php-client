<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet\ExtendedData;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Delete extends AbstractModel
{
    /**
     * @param string $packetExtendedDataId
     */
    public function __construct(string $packetExtendedDataId)
    {
        parent::__construct([
            'type' => EntityType::PACKET_EXTENDED_DATA,
            'id' => $packetExtendedDataId,
        ]);
    }
}
