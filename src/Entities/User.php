<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class User
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $email
 * @property string $phone_number
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Token $token
 */
class User extends BaseEntity
{
    protected $type = EntityType::USER;

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
