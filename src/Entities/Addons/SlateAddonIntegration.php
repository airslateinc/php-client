<?php

namespace AirSlate\ApiClient\Entities\Addons;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * Class SlateAddonIntegration
 * @package AirSlate\ApiClient\Entities\Addons
 * @property string|null $access_token
 * @property string|null $email
 * @property string|null $authorization_url
 * @property-read SlateAddon $slate_addon
 */
class SlateAddonIntegration extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::SLATE_ADDON_INTEGRATION;
}
