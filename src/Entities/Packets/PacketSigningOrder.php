<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Packets;

use Exception;
use AirSlate\ApiClient\Entities\User;
use AirSlate\ApiClient\Entities\BaseEntity;

/**
 * Class PacketSigningOrder
 * @package AirSlate\ApiClient\Entities\Packets
 *
 * @property string $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $order
 * @property string $role
 * @property string $status
 *
 * @property-read User[] $users
 */
class PacketSigningOrder extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'packet_signing_order';

    /**
     * @return User[]
     * @throws Exception
     */
    public function getUsers(): array
    {
        return $this->hasMany(User::class, 'users');
    }
}
