<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class AssignRole extends AbstractModel
{
    /**
     * @param string $roleUid
     * @param array $email
     * @param array $contactGroups
     * @param InviteEmailAddition|null $emailAddition
     */
    public function addRole(
        string $roleUid,
        array $email,
        array $contactGroups,
        ?InviteEmailAddition $emailAddition = null
    ): void {
        $payload = [
            'type' => EntityType::PACKET_ROLES_ASSIGN,
            'attributes' => [
                'email' => $email,
                'contact_groups' => $contactGroups,
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
