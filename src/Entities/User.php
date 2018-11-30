<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class User
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $email
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Organization[] $organizations
 * @property-read Token $token
 */
class User extends BaseEntity
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getOrganizations(): array
    {
        return $this->hasMany(Organization::class, 'organizations');
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
