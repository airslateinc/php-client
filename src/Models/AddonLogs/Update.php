<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\AddonLogs;

use AirSlate\ApiClient\Entities\EntityType;

class Update extends AbstractAddonLog
{
    /** @var string */
    private $addonLogUid = '';

    /**
     * @param string $addonLogUid
     */
    public function setUid(string $addonLogUid): void
    {
        $this->addonLogUid = $addonLogUid;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::SLATE_ADDON_LOG,
                'id' => $this->addonLogUid,
                'attributes' => [
                    'status' => $this->status,
                    'run_once' => $this->runOnce,
                    'conditions' => $this->condition,
                    'response_body' => $this->responseBody,
                ],
            ],
        ];
    }
}
