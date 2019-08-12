<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Class SlateInvite
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $email
 * @property string $access
 * @property bool   $ignored
 * @property string $created_at
 * @property string $updated_at
 */
class SlateInvite extends BaseEntity
{
    protected $type = EntityType::SLATE_INVITE;
}
