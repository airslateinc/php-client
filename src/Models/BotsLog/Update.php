<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\BotsLog;

use AirSlate\ApiClient\Entities\EntityType;

class Update extends AbstractBotsLog
{
    /** @var string  */
    private $uid = '';

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
        $payload = [
            'type' => EntityType::SLATE_ADDON_LOGS,
            'id' => $this->uid,
            'attributes' => [
                'status' => $this->status,
                'run_once' => $this->run_once,
                'conditions' => $this->condition,
                'response_body' => $this->responseBody
            ]
        ];

        return ['data' => $payload];
    }
}
