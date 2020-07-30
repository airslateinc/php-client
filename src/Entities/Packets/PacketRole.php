<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Entities\User;

/**
 * Class PacketSend
 * @package AirSlate\ApiClient\Entities\Packets
 *
 * @property string $id
 * @property string $title
 * @property string $status
 * @property string $role_type
 * @property int $required_fields
 * @property int $order
 * @property int $number_documents
 * @property int $fillable_fields
 */
class PacketRole extends BaseEntity
{
    /** @var string */
    protected $type = EntityType::PACKET_ROLES;

    /**
     * @return User[]
     * @throws \Exception
     */
    public function getUsers(): array
    {
        return $this->hasMany(User::class, 'users');
    }
}
