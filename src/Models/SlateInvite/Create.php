<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\SlateInvite;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Enums\SlateInviteAccess;
use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    /** @var string */
    private $email;

    /** @var SlateInviteAccess */
    private $access;

    /** @var bool */
    private $hasCountGroup;

    /** @var string */
    private $emailAdditionsId;

    /**
     * @param string $email
     * @param SlateInviteAccess $access
     * @param bool $hasCountGroup
     * @param string $emailAdditionsId
     */
    public function __construct(string $email, SlateInviteAccess $access, bool $hasCountGroup, string $emailAdditionsId)
    {
        parent::__construct([]);
        $this->email = $email;
        $this->access = $access;
        $this->hasCountGroup = $hasCountGroup;
        $this->emailAdditionsId = $emailAdditionsId;
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        return [
            'data' => [
                [
                    'type' => EntityType::SLATE_INVITE,
                    'attributes' => [
                        'email' => $this->email,
                        'access' => $this->access->getValue(),
                        'has_contact_group' => $this->hasCountGroup,
                    ],
                    'relationships' => [
                        'invite_email_additions' => [
                            'type' => 'invite_email_additions',
                            'id' => $this->emailAdditionsId,
                        ],
                    ],
                ],
            ],
        ];
    }
}
