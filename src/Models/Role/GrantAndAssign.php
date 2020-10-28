<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Role;

use AirSlate\ApiClient\Entities\ContactGroup;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Entities\RelationshipEntityType;
use AirSlate\ApiClient\Entities\User;
use AirSlate\ApiClient\Models\AbstractModel;
use AirSlate\ApiClient\Models\Packet\InviteEmailAddition;

class GrantAndAssign extends AbstractModel
{
    /** @var array */
    private $relationships;

    /** @var bool */
    private $accessGranted = true;

    /** @var bool */
    private $skipEmail = false;

    /**
     * @param bool $accessGranted
     */
    public function setAccessGranted(bool $accessGranted): void
    {
        $this->accessGranted = $accessGranted;
    }

    /**
     * @param bool $skipEmail
     */
    public function setSkipEmail(bool $skipEmail): void
    {
        $this->skipEmail = $skipEmail;
    }

    /**
     * @param User $user
     */
    public function addUser(User $user): void
    {
        $this->relationships[EntityType::USER]['data'][] = [
            'type' => EntityType::USER,
            'id' => $user->id
        ];

        $this->included[] = [
            'id' => $user->id,
            'type' => EntityType::USER,
            'attributes' => [
                'email' => $user->email,
            ]
        ];
    }

    /**
     * @param InviteEmailAddition $inviteEmailAddition
     */
    public function addInviteEmailAddition(InviteEmailAddition $inviteEmailAddition): void
    {
        $this->relationships[RelationshipEntityType::INVITE_EMAIL_ADDITION]['data'] = [
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
     * @param ContactGroup $contactGroup
     */
    public function addContactGroup(ContactGroup $contactGroup): void
    {
        $this->relationships[RelationshipEntityType::CONTACT_GROUP]['data'] = [
            'type' => EntityType::CONTACT_GROUP,
            'id' => $contactGroup->id,
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
                    'skip_email' => $this->skipEmail,
                ],
                'relationships' => $this->relationships
            ],
            'included' => $this->included
        ];
    }
}
