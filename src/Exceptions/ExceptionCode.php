<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Exceptions;

interface ExceptionCode
{
    public const FORBIDDEN_CHANGE_PACKET_ROLE_USER_FOR_BOT = 14086;
    public const PAYWALL_SLATES_API = 12112;
    public const PAYWALL_EXPORT_API = 17001;
    public const INVALID_FIELD_VALUE = 24031;
}
