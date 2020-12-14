<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet\ExtendedData;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    /**
     * @param string $ownerKey
     * @param string $dataContext
     * @param string $dataKey
     * @param string $dataValue
     * @param string[] $readPacketPermissions
     */
    public function __construct(
        string $ownerKey,
        string $dataContext,
        string $dataKey,
        string $dataValue,
        array $readPacketPermissions
    ) {
        parent::__construct([
            'type' => EntityType::PACKET_EXTENDED_DATA,
            'attributes' => [
                'owner_key' => $ownerKey,
                'data_context' => $dataContext,
                'data_key' => $dataKey,
                'data_value' => $dataValue,
                'read_packet_permissions' => $readPacketPermissions,
            ]
        ]);
    }
}
