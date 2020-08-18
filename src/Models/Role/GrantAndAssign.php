<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Role;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;
use AirSlate\ApiClient\Models\Packet\InviteEmailAddition;

class GrantAndAssign extends AbstractModel
{
    /** @var array */
    private $relationships;

    /** @var array */
    protected $included;

    /** @var bool */
    private $accessGranted;

    /**
     * @param bool $accessGranted
     */
    public function setAccessGranted(bool $accessGranted): void
    {
        $this->accessGranted = $accessGranted;
    }

    /**
     * @param string $email
     */
    public function addUser(string $email): void
    {
        $uniqId = uniqid();

        $this->relationships[EntityType::USER]['data'][] = [
            'type' => EntityType::USER,
            'id' => $uniqId
        ];

        $this->included[] = [
            'id' => $uniqId,
            'type' => EntityType::USER,
            'attributes' => [
                'email' => $email,
            ]
        ];
    }

    /**
     * @param InviteEmailAddition $inviteEmailAddition
     */
    public function addInviteEmailAddition(InviteEmailAddition $inviteEmailAddition): void
    {
        $this->relationships[InviteEmailAddition::RELATIONSHIP_KEY_NEW]['data'] = [
            'type' => EntityType::INVITE_EMAIL_ADDITION,
            'id' => $inviteEmailAddition->getId(),
        ];

        $attributes = [
            'subject' => $inviteEmailAddition->getSubject(),
            'text' => $inviteEmailAddition->getText(),
        ];

        if ($inviteEmailAddition->getCustomPreheader() !== null) {
            $attributes['custom_preheader'] = $inviteEmailAddition->getCustomPreheader();
        }

        if ($inviteEmailAddition->getCustomTitle() !== null) {
            $attributes['custom_title'] = $inviteEmailAddition->getCustomTitle();
        }

        $this->included[] = [
            'id' => $inviteEmailAddition->getId(),
            'type' => EntityType::INVITE_EMAIL_ADDITION,
            'attributes' => $attributes
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::PACKET_ROLES,
                'attributes' => [
                    'access_granted' => $this->accessGranted,
                ],
                'relationships' => $this->relationships
            ],
            'included' => $this->included
        ];
    }
}
