<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\BotsLog;

use AirSlate\ApiClient\Models\AbstractModel;

abstract class AbstractBotsLog extends AbstractModel
{
    /** @var array  */
    protected $responseBody = [];

    /** @var string  */
    private $status = '';

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
}
