<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet\SigningOrder;

use AirSlate\ApiClient\Models\AbstractModel;

class Enable extends AbstractModel
{
    /** @var array */
    private $included;

    /**
     * @param string $role
     * @param string $email
     * @param int $order
     * @return void
     */
    public function enable(string $role, string $email, int $order): void
    {
        $this->data[] = [
            'type' => 'packet_signing_order',
            'attributes' => [
                'role_id' => $role,
                'email' => $email,
                'order' => $order,
            ],
        ];
    }

    /**
     * @param string $packetUid
     * @param bool $isOrderEnabled
     * @return void
     */
    public function setPacket(string $packetUid, bool $isOrderEnabled): void
    {
        $this->included = [
            [
                'id' => $packetUid,
                'type' => 'packets',
                'attributes' => [
                    'signing_order_enabled' => $isOrderEnabled,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'included' => $this->included,
        ];
    }
}
