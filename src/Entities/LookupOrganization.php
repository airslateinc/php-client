<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * @property string $id
 * @property string $name
 * @property string $attribute
 */
class LookupOrganization extends BaseEntity
{
    protected $type = EntityType::LOOKUP_ORGANIZATION;
}
