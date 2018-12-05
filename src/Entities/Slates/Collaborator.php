<?php

namespace AirSlate\ApiClient\Entities\Slates;

use AirSlate\ApiClient\Entities\BaseEntity;

/**
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
    protected $type = 'slate_collaborators';
}
