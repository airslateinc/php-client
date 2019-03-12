<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet\Send;

use AirSlate\ApiClient\Models\ArrayableInterface;

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
            'type' => 'packet_send',
            'attributes' => [
                'email' => $this->email,
                'access_level' => $this->accessLevel,
            ],
        ];
    }
}
