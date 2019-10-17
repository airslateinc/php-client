<?php

namespace AirSlate\ApiClient\Entities\Slates;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * @deprecated SlateInvites should be used
 * @see \AirSlate\ApiClient\Entities\SlateInvite
 *
 * Class Collaborator
 * @package AirSlate\ApiClient\Entities\Slates
 *
 * @property $email
 * @property $user_id
 * @property $access
 * @property $organization_id
 * @property $created_at
 * @property $updated_at
 */
class Collaborator extends BaseEntity
{
    protected $type = EntityType::SLATE_COLLABORATOR;
}
