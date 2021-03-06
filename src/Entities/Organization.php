<?php

namespace AirSlate\ApiClient\Entities;

use Exception;

/**
 * Class Organization
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $subdomain
 * @property string $name
 * @property string $category
 * @property string $size
 * @property int $auto_generated
 * @property string $logo_profile
 * @property string $logo_rectangle
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read User $owner
 * @property-read User[] $users
 * @property-read bool $autoGenerated
 */
class Organization extends BaseEntity
{
    protected $type = EntityType::ORGANIZATION;

    /**
     * @return BaseEntity|User|null
     * @throws Exception
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, 'owner');
    }

    /**
     * @return User[]
     * @throws Exception
     */
    public function getUsers(): array
    {
        return $this->hasMany(User::class, 'users');
    }

    /**
     * @return bool
     */
    public function getAutoGenerated(): bool
    {
        return $this->getObjectMetaAttribute('auto_generated');
    }
}
