<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Enums;

class SlateInviteAccess extends BaseEnum
{
    // POSSIBLE VALUES
    public const IS_OWNER = 'IS_OWNER';
    public const CAN_SHARE = 'CAN_SHARE';
    public const CAN_READ = 'CAN_READ';
    public const READ_ONLY = 'READ_ONLY';
    public const CAN_USE = 'CAN_USE';
    public const CAN_FILL = 'CAN_FILL';
    public const CAN_EDIT = 'CAN_EDIT';

    /** @const string[] */
    private const POSSIBLE_FIELDS = [
        self::IS_OWNER,
        self::CAN_SHARE,
        self::CAN_READ,
        self::READ_ONLY,
        self::CAN_USE,
        self::CAN_FILL,
        self::CAN_EDIT,
    ];

    /**
     * @return string[]
     */
    protected function getPossibleValues(): array
    {
        return self::POSSIBLE_FIELDS;
    }
}
