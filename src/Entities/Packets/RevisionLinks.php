<?php

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

class RevisionLinks extends BaseEntity
{
    protected $type = EntityType::PACKET_REVISION_LINK;
}
