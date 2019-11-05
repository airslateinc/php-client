<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\BotsLog;

use AirSlate\ApiClient\Entities\EntityType;

class Create extends AbstractBotsLog
{
    /** @var string  */
    private $slateAdonUID = '';

    /** @var string  */
    private $packetRevisionUID = '';

    /** @var string  */
    private $packetUID = '';

    /**
     * @param string $slateAdonUID
     */
    public function setSlateAdonUID(string $slateAdonUID): void
    {
        $this->slateAdonUID = $slateAdonUID;
    }

    /**
     * @param string $packetRevisionUID
     */
    public function setPacketRevisionUID(string $packetRevisionUID): void
    {
        $this->packetRevisionUID = $packetRevisionUID;
    }

    /**
     * @param string $packerUID
     */
    public function setPacketUID(string $packerUID): void
    {
        $this->packetUID = $packerUID;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $payload = [
            'type' => EntityType::SLATE_ADDON_LOGS,
            'attributes' => [
                'status' => $this->status,
                'run_once' => $this->run_once,
                'conditions' => $this->condition,
                'response_body' => $this->responseBody,
            ],
            'relationships' => [
                'slate_addon' => [
                    'data' => [
                        'id' => $this->slateAdonUID,
                        'type' => EntityType::SLATE_ADDON
                    ]
                ],
            ]
        ];

        // Relationship revision not required.
        // Can pass slate.
        if($this->packetRevisionUID !== '') {
            $payload['relationships']['revision'] = $this->makeRevisionStructure();
        }

        if($this->packetUID !== '') {
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
                'id' => $this->packetRevisionUID,
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
                'id' => $this->packetUID,
                'type' => EntityType::PACKET
            ]
        ];
    }
}
