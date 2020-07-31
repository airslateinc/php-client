<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Class PacketSend
 * @package AirSlate\ApiClient\Entities\Packets
 *
 * @property string $id
 * @property string $title
 */
class ContactGroup extends BaseEntity
{
    /** @var string */
    protected $type = EntityType::CONTACT_GROUP;
}
