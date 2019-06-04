<?php
declare(strict_types = 1);

namespace AirSlate\ApiClient\Entities\DocumentPermissions;

class ActiveModebarTab extends CustomStringOption
{
    const ACTIVE_TAB_FILL = 'main';
    const ACTIVE_TAB_CONSTRUCT = 'constructor';
    const ACTIVE_TAB_PREVIEW = 'preview';

    /**
     * ActiveModebarTab constructor.
     * @param bool $value
     */
    public function __construct(bool $value = self::ACTIVE_TAB_CONSTRUCT)
    {
        parent::__construct($value);
    }
}
