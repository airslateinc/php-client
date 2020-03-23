<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\DocumentRole;
use Exception;
use AirSlate\ApiClient\Entities\User;
use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

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
 * @property-read User $user
 * @property-read DocumentRole $documentRole
 */
class PacketSigningOrder extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::PACKET_SIGNING_ORDER;

    /**
     * @return User|BaseEntity
     * @throws Exception
     */
    public function getUser(): User
    {
        return $this->hasOne(User::class, 'users');
    }

    /**
     * @return DocumentRole|BaseEntity
     */
    public function getDocumentRole(): DocumentRole
    {
        return $this->hasOne(DocumentRole::class, 'roles');
    }
}
