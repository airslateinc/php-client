<?php

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * Class PacketSend
 * @package AirSlate\ApiClient\Entities\Packets
 *
 * @property string $id
 * @property string $email
 * @property string $user_id
 * @property string $access_level
 * @property string $created_at
 * @property string $updated_at
 * @property string $sender_uid
 */
class PacketSend extends BaseEntity
{
    protected $type = EntityType::PACKET_SEND;

    public const ACCESS_LEVEL_READ  = 'READ';
    public const ACCESS_LEVEL_WRITE = 'WRITE';
}
