<?php

namespace AirSlate\ApiClient\Entities\Slates;

use AirSlate\ApiClient\Entities\BaseEntity;

/**
 * Class Token
 * @package AirSlate\ApiClient\Entities
 *
 * @property-read null|string $tokenType
 * @property-read null|string $expires
 * @property-read null|string $accessToken
 * @property-read null|string $refreshToken
 */
class Document extends BaseEntity
{
    /**
     * @return null|string
     */
    public function getDocumentType(): ?string
    {
        return $this->getMeta('document_type');
    }
}
