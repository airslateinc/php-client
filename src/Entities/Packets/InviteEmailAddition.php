<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * Class InviteEmailAddition
 * @package AirSlate\ApiClient\Entities\Packets
 *
 * @property string $id
 * @property string $subject
 * @property string $text
 */
class InviteEmailAddition extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::INVITE_EMAIL_ADDITION;

    /**
     * @var string
     */
    public const DEFAULT_ID = 'generic_id';

    /**
     * @var string
     */
    public const RELATIONSHIP_KEY = 'invite_email_additions';
}
