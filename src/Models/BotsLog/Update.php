<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\BotsLog;

use AirSlate\ApiClient\Entities\EntityType;

class Update extends AbstractBotsLog
{
    /** @var string  */
    private $uid = '';

    /** @var string  */
    private $status = '';

    /**
     * @param string $uid
     */
    public function setUID(string $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => EntityType::SLATE_ADDON_LOGS,
            'id' => $this->uid,
            'attributes' => [
                'status' => $this->status,
                'run_once' => $this->run_once,
                'condition' => $this->condition,
                'response_body' => $this->responseBody
            ]
        ];
    }
}
