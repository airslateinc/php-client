<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * @property string $id
 * @property string $code
 * @property int $default
 * @property int $position
 * @property string $title
 */
class ParticipantRole extends BaseEntity
{
    public const CODE_WORKSPACE_OWNER = 'WORKSPACE_OWNER';
    public const CODE_SUPERVISOR = 'SUPERVISOR';
    public const CODE_DOCUMENT_AUDITOR = 'DOCUMENT_AUDITOR';
    public const CODE_FLOW_CREATOR = 'FLOW_CREATOR';
    public const CODE_MEMBER = 'MEMBER';
    public const CODE_PARTNER = 'PARTNER';

    protected $type = EntityType::PARTICIPANT_ROLES;
}
