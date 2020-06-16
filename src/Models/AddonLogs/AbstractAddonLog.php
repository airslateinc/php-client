<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\AddonLogs;

use AirSlate\ApiClient\Models\AbstractModel;

abstract class AbstractAddonLog extends AbstractModel
{
    /** @var string  */
    public const STATUS_PENDING = 'PENDING';

    /** @var string  */
    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';

    /** @var string  */
    public const STATUS_FAIL = 'FAILED';

    /** @var string  */
    public const STATUS_DONE = 'DONE';

    /** @var string  */
    protected const PASSED = 'PASSED';

    /** @var string */
    protected const DEFAULT_TRIGGER = 'schedule';

    /** @var array  */
    protected $responseBody = [];

    /** @var string  */
    protected $status = self::STATUS_PENDING;

    /** @var string  */
    protected $runOnce = self::PASSED;

    /** @var string  */
    protected $condition = self::PASSED;

    /** @var null|string */
    protected $trigger = null;

    /**
     * @param array $responseBody
     */
    public function setResponseBody(array $responseBody): void
    {
        $this->responseBody = $responseBody;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @param string $runOnce
     */
    public function setRunOnce(string $runOnce): void
    {
        $this->runOnce = $runOnce;
    }

    /**
     * @param string $condition
     */
    public function setCondition(string $condition): void
    {
        $this->condition = $condition;
    }

    /**
     * @param string $trigger
     */
    public function setTrigger(string $trigger = self::DEFAULT_TRIGGER): void
    {
        $this->trigger = $trigger;
    }
}
