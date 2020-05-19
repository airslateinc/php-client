<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\ArrayableInterface;

class ResendPacketInvite implements ArrayableInterface
{
    /** @var string */
    protected $email;

    /** @var string */
    private $userUid;

    /** @var string */
    private $packetRoleUid;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data =  [
            'type' => EntityType::RESEND_PACKET_INVITE,
        ];

        if (isset($this->email)) {
            $data['attributes']['email'] = $this->email;
        }

        if (isset($this->userUid)) {
            $data['relationships']['users'] = [
                'data' => [
                    'id' => $this->userUid,
                    'type' => EntityType::USER
                ]
            ];
        }

        if (isset($this->packetRoleUid)) {
            $data['relationships']['packet_roles'] = [
                'data' => [
                    'id' => $this->packetRoleUid,
                    'type' => EntityType::PACKET_ROLES
                ]
            ];
        }

        return [
            'data' => $data
        ];
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $userUid
     * @return $this
     */
    public function setUserUid(string $userUid): self
    {
        $this->userUid = $userUid;

        return $this;
    }

    /**
     * @param string $packetRoleUid
     * @return $this
     */
    public function setPacketRoleUid(string $packetRoleUid): self
    {
        $this->packetRoleUid = $packetRoleUid;

        return $this;
    }
}
