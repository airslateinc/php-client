<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class Packet
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $versions
 * @property string $status
 * @property bool $signing_order_enabled
 * @property string $created_at
 * @property string $updated_at
 *
 */

class Packet extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::PACKET;

    /**
     * @return array
     * @throws \Exception
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::class, 'documents');
    }

    /**
     * @return User
     * @throws \Exception
     */
    public function getAuthor(): User
    {
        return $this->hasOne(User::class, 'authors');
    }
}
