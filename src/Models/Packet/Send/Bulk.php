<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet\Send;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;
use AirSlate\ApiClient\Models\Packet\InviteEmailAddition;

/**
 * Class Bulk
 * @package AirSlate\ApiClient\Models\Packet\Send
 *
 */
class Bulk extends AbstractModel
{
    /**
     * @param string $email
     * @param string $accessLevel
     * @param InviteEmailAddition|null $emailAddition
     * @return void
     */
    public function addPacketSend(
        string $email,
        string $accessLevel,
        ?InviteEmailAddition $emailAddition = null
    ): void {
        $payload = [
            'type' => EntityType::PACKET_SEND,
            'attributes' => [
                'email' => $email,
                'access_level' => $accessLevel,
            ],
        ];

        if ($emailAddition !== null) {
            $payload['relationships'][InviteEmailAddition::RELATIONSHIP_KEY] = [
                'type' => EntityType::INVITE_EMAIL_ADDITION,
                'id' => $emailAddition->id,
            ];

            $this->setInviteEmailAddition($emailAddition);
        }

        $this->data[] = $payload;
    }

    /**
     * @param InviteEmailAddition $emailAddition
     * @return void
     */
    private function setInviteEmailAddition(InviteEmailAddition $emailAddition): void
    {
        if (array_search($emailAddition->getId(), array_column($this->included, 'id')) === false) {
            $this->included[] = [
                'id' => $emailAddition->id,
                'type' => EntityType::INVITE_EMAIL_ADDITION,
                'attributes' => [
                    'subject' => $emailAddition->subject,
                    'text' => $emailAddition->text,
                ]
            ];
        }
    }
}
