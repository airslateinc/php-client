<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class Token
 * @package AirSlate\ApiClient\Entities
 *
 * @property-read null|string $tokenType
 * @property-read null|string $expires
 * @property-read null|string $accessToken
 * @property-read null|string $refreshToken
 */
class Token extends BaseEntity
{
    /**
     * @return null|string
     */
    public function getTokenType(): ?string
    {
        return $this->getMeta('token_type');
    }

    /**
     * @return null|string
     */
    public function getExpires(): ?string
    {
        return $this->getMeta('expires');
    }

    /**
     * @return null|string
     */
    public function getAccessToken(): ?string
    {
        return $this->getMeta('access_token');
    }

    /**
     * @return null|string
     */
    public function getRefreshToken(): ?string
    {
        return $this->getMeta('refresh_token');
    }
}
