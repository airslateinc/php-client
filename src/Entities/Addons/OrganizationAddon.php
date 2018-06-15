<?php

namespace AirSlate\ApiClient\Entities\Addons;

use AirSlate\ApiClient\Entities\Addon;
use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\Organization;
use AirSlate\ApiClient\Entities\User;

/**
 * Class OrganizationAddon
 *
 * @property string $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Addon $addon
 * @property-read Organization $organization
 * @property-read User $admin
 * @property-read User $addon_user
 *
 * @package AirSlate\ApiClient\Entities\Addons
 */
class OrganizationAddon extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'organization_addons';
    
    /**
     * @return Addon|null
     * @throws \Exception
     */
    public function getAddon(): ?Addon
    {
        return $this->hasOne(Addon::class, 'addon');
    }
    
    /**
     * @return Organization|null
     * @throws \Exception
     */
    public function getOrganization(): ?Organization
    {
        return $this->hasOne(Organization::class, 'organization');
    }
    
    /**
     * @return User|null
     * @throws \Exception
     */
    public function getAdmin(): ?User
    {
        return $this->hasOne(User::class, 'admin');
    }
    
    /**
     * @return User|null
     * @throws \Exception
     */
    public function getAddonUser(): ?User
    {
        return $this->hasOne(User::class, 'addon_user');
    }
}
