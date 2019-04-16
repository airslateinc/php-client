<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;

class PacketSigningOrder extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'packet_signing_order';
}
