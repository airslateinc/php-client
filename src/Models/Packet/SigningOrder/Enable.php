<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet\SigningOrder;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;
use AirSlate\ApiClient\Models\Packet\InviteEmailAddition;

class Enable extends AbstractModel
{
    /**
     * @param string $role
     * @param string|null $email
     * @param int $order
     * @param InviteEmailAddition $emailAddition
     * @return void
     */
    public function enable(string $role, ?string $email, int $order, ?InviteEmailAddition $emailAddition = null): void
    {
        $payload = [
            'type' => 'packet_signing_order',
            'attributes' => [
                'role' => $role,
                'order' => $order,
            ],
        ];

        if (!empty($email)) {
            $payload['attributes']['email'] = $email;
        }

        if ($emailAddition !== null) {
            $payload['relationships'][InviteEmailAddition::RELATIONSHIP_KEY] = [
                'type' => EntityType::INVITE_EMAIL_ADDITION,
                'id' => $emailAddition->getId(),
            ];

            $this->setInviteEmailAddition($emailAddition);
        }

        $this->data[] = $payload;
    }

    /**
     * @param string $packetUid
     * @param bool $isOrderEnabled
     * @return void
     */
    public function setPacket(string $packetUid, bool $isOrderEnabled): void
    {
        $this->included[] = [
            'id' => $packetUid,
            'type' => 'packets',
            'attributes' => [
                'signing_order_enabled' => $isOrderEnabled,
            ],
        ];
    }

    /**
     * @param InviteEmailAddition $emailAddition
     * @return void
     */
    private function setInviteEmailAddition(InviteEmailAddition $emailAddition): void
    {
        if (array_search($emailAddition->getId(), array_column($this->included, 'id')) === false) {
            $this->included[] = [
                'id' => $emailAddition->getId(),
                'type' => EntityType::INVITE_EMAIL_ADDITION,
                'attributes' => [
                    'subject' => $emailAddition->getSubject(),
                    'text' => $emailAddition->getText(),
                ]
            ];
        }
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
