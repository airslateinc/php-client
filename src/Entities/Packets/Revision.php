<?php

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

class Revision extends BaseEntity
{
    protected $type = EntityType::PACKET_REVISION;
}
