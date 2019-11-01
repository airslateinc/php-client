<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\BotsLog;

use AirSlate\ApiClient\Entities\EntityType;

class Create extends AbstractBotsLog
{
    /** @var string  */
    private const STATUS_PENDING = 'PENDING';

    /** @var string  */
    private const PASSED = 'PASSED';

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
            'type' => 'slate_addon_logs',
            'attributes' => [
                'status' => self::STATUS_PENDING,
                'run_once' => self::PASSED,
                'condition' => self::PASSED,
                'response_body' => $this->responseBody,
            ],
            'relationship' => [
                'slate_addon' => [
                    'data' => [
                        'id' => $this->slateAdonUID,
                        'type' => EntityType::SLATE_ADDON
                    ]
                ],
            ]
        ];

        if($this->packetRevisionUID !== '') {
            $payload['relationship']['revision'] = $this->makeRevisionStructure();
        }

        if($this->packetUID !== '') {
            $payload['relationship']['packet'] = $this->makePacketStructure();
        }

        return $payload;
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
