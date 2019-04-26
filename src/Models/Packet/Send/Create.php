<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet\Send;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\ArrayableInterface;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Models
 *
 */
class Create implements ArrayableInterface
{
    private const INVITE_EMAIL_ADDITION_DEFAULT_ID = 'generic_id';

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
     * @param bool $text
     * @return void
     */
    public function setInviteEmailAddition(string $subject, bool $text): void
    {
        $this->relationships[EntityType::INVITE_EMAIL_ADDITION] = [
            'type' => EntityType::INVITE_EMAIL_ADDITION,
            'id' => self::INVITE_EMAIL_ADDITION_DEFAULT_ID
        ];

        $this->included[] = [
            'id' => self::INVITE_EMAIL_ADDITION_DEFAULT_ID,
            'type' => EntityType::INVITE_EMAIL_ADDITION,
            'attributes' => [
                'subject' => $subject,
                'text' => $text,
            ]
        ];
    }
}
