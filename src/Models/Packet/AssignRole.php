<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class AssignRole extends AbstractModel
{
    /**
     * @param string $roleUid
     * @param string[] $email
     * @param string[] $contactGroups
     * @param InviteEmailAddition|null $emailAddition
     * @param int|null $order
     * @param int[] $phoneNumbers
     */
    public function addRole(
        string $roleUid,
        array $email,
        array $contactGroups,
        ?InviteEmailAddition $emailAddition = null,
        int $order = null,
        array $phoneNumbers = []
    ): void {
        $payload = [
            'type' => EntityType::PACKET_ROLES_ASSIGN,
            'attributes' => [
                'email' => $email,
                'contact_groups' => $contactGroups,
                'phone_numbers' => $phoneNumbers,
            ],
            'relationships' => [
                'packet_roles' => [
                    'data' => [
                        'id' => $roleUid,
                        'type' => EntityType::PACKET_ROLES
                    ]
                ]
            ]
        ];

        if ($order !== null) {
            $payload['attributes']['order'] = $order;
        }

        if ($emailAddition !== null) {
            $payload['relationships'][InviteEmailAddition::RELATIONSHIP_KEY] = [
                'type' => EntityType::INVITE_EMAIL_ADDITION,
                'id' => $emailAddition->getId(),
            ];

            $this->addInviteEmailAddition($emailAddition);
        }

        $this->data[] = $payload;
    }

    /**
     * @param InviteEmailAddition $emailAddition
     * @return void
     */
    private function addInviteEmailAddition(InviteEmailAddition $emailAddition): void
    {
        if (array_search($emailAddition->getId(), array_column($this->included, 'id')) === false) {
            $attributes = [
                'subject' => $emailAddition->getSubject(),
                'text' => $emailAddition->getText(),
            ];

            if ($emailAddition->getCustomPreheader() !== null) {
                $attributes['custom_preheader'] = $emailAddition->getCustomPreheader();
            }

            if ($emailAddition->getCustomTitle() !== null) {
                $attributes['custom_title'] = $emailAddition->getCustomTitle();
            }

            $this->included[] = [
                'id' => $emailAddition->getId(),
                'type' => EntityType::INVITE_EMAIL_ADDITION,
                'attributes' => $attributes
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
