<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\AddonLogs;

use AirSlate\ApiClient\Entities\EntityType;

class Create extends AbstractAddonLogs
{
    /** @var string  */
    private $slateAddonUid = '';

    /** @var string  */
    private $packetRevisionUid = '';

    /** @var string  */
    private $packetUid = '';

    /**
     * @param string $slateAddonUid
     */
    public function setSlateAdonUid(string $slateAddonUid): void
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
     * @param string $packerUid
     */
    public function setPacketUid(string $packerUid): void
    {
        $this->packetUid = $packerUid;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $payload = [
            'type' => EntityType::SLATE_ADDON_LOG,
            'attributes' => [
                'status' => $this->status,
                'run_once' => $this->run_once,
                'conditions' => $this->condition,
                'response_body' => $this->responseBody,
            ],
            'relationships' => [
                'slate_addon' => [
                    'data' => [
                        'id' => $this->slateAddonUid,
                        'type' => EntityType::SLATE_ADDON
                    ]
                ],
            ]
        ];

        // Relationship revision not required.
        // Can pass slate.
        if($this->packetRevisionUid !== '') {
            $payload['relationships']['revision'] = $this->makeRevisionStructure();
        }

        if($this->packetUid !== '') {
            $payload['relationships']['packet'] = $this->makePacketStructure();
        }

        return ['data' => $payload];
    }

    /**
     * @return array
     */
    private function makeRevisionStructure(): array
    {
        return [
            'data' => [
                'id' => $this->packetRevisionUid,
                'type' => EntityType::PACKET_REVISION
            ]
        ];
    }

    /**
     * @return array
     */
    private function makePacketStructure(): array
    {
        return [
            'data' => [
                'id' => $this->packetUid,
                'type' => EntityType::PACKET
            ]
        ];
    }
}
