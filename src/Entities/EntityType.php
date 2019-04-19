<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

interface EntityType
{
    public const FLOW_ROLE = 'flow_roles';
    public const FLOW_ROLE_DOCUMENT = 'flow_role_documents';
    public const FLOW_ROLE_FIELD = 'flow_role_fields';
    public const SLATE = 'slates';
    public const DOCUMENT = 'documents';
}