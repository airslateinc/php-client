<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\AddonLogs;

use AirSlate\ApiClient\Entities\EntityType;

class Create extends AbstractAddonLog
{
    /** @var string  */
    private $slateAddonUid;

    /** @var string  */
    private $packetRevisionUid;

    /** @var string  */
    private $packetUid;

    /**
     * @param string $slateAddonUid
     */
    public function setSlateAddonUid(string $slateAddonUid): void
    {
        $this->slateAddonUid = $slateAddonUid;
    }

    /**
     * @param string $packetRevisionUid
     */
    public function setPacketRevisionUid(string $packetRevisionUid): void
    {
        $this->packetRevisionUid = $packetRevisionUid;
    }

    /**
     * @param string $packetUid
     */
    public function setPacketUid(string $packetUid): void
    {
        $this->packetUid = $packetUid;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $payload = [
            'data' => [
                'type' => EntityType::SLATE_ADDON_LOG,
                'attributes' => [
                    'status' => $this->status,
                    'run_once' => $this->runOnce,
                    'conditions' => $this->condition,
                    'response_body' => $this->responseBody,
                ],
                'relationships' => [
                    'slate_addon' => [
                        'data' => [
                            'id' => $this->slateAddonUid,
                            'type' => EntityType::SLATE_ADDON,
                        ],
                    ],
                ],
            ],
        ];

        if ($this->trigger !== null) {
            $payload['data']['attributes']['trigger'] = $this->trigger;
        }

        if ($this->packetRevisionUid !== null) {
            $payload['data']['relationships']['revision'] = [
                'data' => [
                    'id' => $this->packetRevisionUid,
                    'type' => EntityType::PACKET_REVISION,
                ],
            ];
        }

        if ($this->packetUid !== null) {
            $payload['data']['relationships']['packet'] = [
                'data' => [
                    'id' => $this->packetUid,
                    'type' => EntityType::PACKET,
                ],
            ];
        }

        return $payload;
    }
}
