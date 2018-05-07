<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class User
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Organization $organization
 * @property-read Token $token
 */
class User extends BaseEntity
{
    /**
     * @return BaseEntity|Organization|null
     * @throws \Exception
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::class, 'organization');
    }

    /**
     * @return Token
     */
    public function getToken(): Token
    {
        return Token::createFromMeta([
            'meta' => $this->getMeta()
        ]);
    }
}
