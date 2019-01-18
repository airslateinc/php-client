<?php

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;

/**
 * Class PacketSend
 * @package AirSlate\ApiClient\Entities\Packets
 *
 * @property string $id
 * @property string $email
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $sender_uid
 */
class PacketSend extends BaseEntity
{
    protected $type = 'packet_send';
}
