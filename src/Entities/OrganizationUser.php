<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class OrganizationUser
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $status
 */
class OrganizationUser extends BaseEntity
{
    /**
     * @var string $type
     */
    protected $type = EntityType::ORGANIZATION_USER;

    public function user(): User
    {
        return $this->hasOne(User::class, 'user');
    }
}
