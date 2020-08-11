<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class UnassignRole extends AbstractModel
{
    /** @var string */
    private $packetRoleUid = '';

    /** @var string */
    private $userUid = '';

    /**
     * @param string $userUid
     * @return UnassignRole
     */
    public function setUserUid(string $userUid): self
    {
        $this->userUid = $userUid;

        return $this;
    }

    /**
     * @param string $packetRoleUid
     * @return UnassignRole
     */
    public function setPacketRoleUid(string $packetRoleUid): self
    {
        $this->packetRoleUid = $packetRoleUid;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'id' => $this->packetRoleUid,
                'type' => EntityType::PACKET_ROLES,
                'relationships' => [
                    'users' => [
                        'data' => [
                            [
                                'id' => $this->userUid,
                                'type' => EntityType::USER,
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }
}
