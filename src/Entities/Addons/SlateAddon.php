<?php

namespace AirSlate\ApiClient\Entities\Addons;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\Slate;

/**
 * Class SlateAddon
 *
 * @property string $id
 * @property int $position
 * @property string $event_type
 * @property string $status
 * @property array $settings
 * @property bool $skip_on_fail
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read OrganizationAddon $organization_addon
 * @property-read Slate $slate
 *
 * @package AirSlate\ApiClient\Entities\Addons
 */
class SlateAddon extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'slate_addons';
    
    /**
     * @return OrganizationAddon|null
     * @throws \Exception
     */
    public function getOrganizationAddon(): ?OrganizationAddon
    {
        return $this->hasOne(OrganizationAddon::class, 'organization_addon');
    }
    
    /**
     * @return Slate|null
     * @throws \Exception
     */
    public function getSlate(): ?Slate
    {
        return $this->hasOne(Slate::class, 'slate');
    }
}
