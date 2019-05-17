<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet\Send;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\ArrayableInterface;
use AirSlate\ApiClient\Models\Packet\InviteEmailAddition;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Models
 *
 */
class Create implements ArrayableInterface
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $accessLevel;

    /**
     * @var array
     */
    private $relationships;

    /**
     * @var array
     */
    private $included;

    /**
     * Create PacketSend constructor.
     *
     * @param string $email
     * @param string $accessLevel
     */
    public function __construct(string $email, string $accessLevel)
    {
        $this->email = $email;
        $this->accessLevel = $accessLevel;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::PACKET_SEND,
                'attributes' => [
                    'email' => $this->email,
                    'access_level' => $this->accessLevel,
                ],
                'relationships' => $this->relationships
            ],
            'included' => $this->included
        ];
    }

    /**
     * @param string $subject
     * @param string $text
     * @return void
     */
    public function setInviteEmailAddition(string $subject, string $text): void
    {
        $this->relationships[InviteEmailAddition::RELATIONSHIP_KEY] = [
            'type' => EntityType::INVITE_EMAIL_ADDITION,
            'id' => InviteEmailAddition::DEFAULT_ID
        ];

        $this->included[] = [
            'id' => InviteEmailAddition::DEFAULT_ID,
            'type' => EntityType::INVITE_EMAIL_ADDITION,
            'attributes' => [
                'subject' => $subject,
                'text' => $text,
            ]
        ];
    }
}
