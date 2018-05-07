<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class Organization
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $subdomain
 * @property string $name
 * @property string $category
 * @property string $size
 * @property string $invite_public_link
 * @property string $invite_domain
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read User $owner
 * @property-read User[] $users
 */
class Organization extends BaseEntity
{
    /**
     * @return BaseEntity|User|null
     * @throws \Exception
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, 'owner');
    }

    /**
     * @return User[]
     * @throws \Exception
     */
    public function getUsers(): array
    {
        return $this->hasMany(User::class, 'users');
    }
}
