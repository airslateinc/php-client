<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * @property string $id
 * @property string $owner_key
 * @property string $data_context
 * @property string $data_key
 * @property string $data_value
 * @property string[] $read_packet_permissions
 */
class PacketExtendedData extends BaseEntity
{
    /** @var string */
    protected $type = EntityType::PACKET_EXTENDED_DATA;
}
