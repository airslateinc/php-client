<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

class RoleDocument extends BaseEntity
{
    protected $type = EntityType::PACKET_ROLE_DOCUMENT;
}
