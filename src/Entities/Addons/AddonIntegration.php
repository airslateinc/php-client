<?php

namespace AirSlate\ApiClient\Entities\Addons;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

class AddonIntegration extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::ADDON_INTEGRATION;
}
