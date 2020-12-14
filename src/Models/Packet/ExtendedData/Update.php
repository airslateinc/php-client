<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet\ExtendedData;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
{
    /**
     * @param string $packetExtendedDataId
     * @param string $dataValue
     * @param string[] $readPacketPermissions
     */
    public function __construct(
        string $packetExtendedDataId,
        string $dataValue,
        array $readPacketPermissions
    ) {
        parent::__construct([
            'type' => EntityType::PACKET_EXTENDED_DATA,
            'id' => $packetExtendedDataId,
            'attributes' => [
                'data_value' => $dataValue,
                'read_packet_permissions' => $readPacketPermissions,
            ]
        ]);
    }
}
