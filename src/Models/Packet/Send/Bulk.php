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

        $this->addEmailAddition($payload, $emailAddition);
    }

    /**
     * @param int $phone
     * @param string $accessLevel
     * @param InviteEmailAddition|null $emailAddition
     */
    public function addPacketSendByPhone(
        int $phone,
        string $accessLevel,
        ?InviteEmailAddition $emailAddition = null
    ): void {
        $payload = [
            'type' => EntityType::PACKET_SEND,
            'attributes' => [
                'phone_number' => $phone,
                'access_level' => $accessLevel,
            ],
        ];

        $this->addEmailAddition($payload, $emailAddition);
    }

    private function addEmailAddition(array $payload, ?InviteEmailAddition $emailAddition = null): void
    {
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
     * @param InviteEmailAddition $emailAddition
     * @return void
     */
    private function setInviteEmailAddition(InviteEmailAddition $emailAddition): void
    {
        if (array_search($emailAddition->getId(), array_column($this->included, 'id')) === false) {
            $currentIncluded = [
                'id' => $emailAddition->getId(),
                'type' => EntityType::INVITE_EMAIL_ADDITION,
                'attributes' => [
                    'subject' => $emailAddition->getSubject(),
                    'text' => $emailAddition->getText(),
                ]
            ];

            if ($emailAddition->getCustomTitle() !== null) {
                $currentIncluded['attributes']['custom_title'] = $emailAddition->getCustomTitle();
            }

            if ($emailAddition->getCustomPreheader() !== null) {
                $currentIncluded['attributes']['custom_preheader'] = $emailAddition->getCustomPreheader();
            }

            $this->included[] = $currentIncluded;
        }
    }
}
