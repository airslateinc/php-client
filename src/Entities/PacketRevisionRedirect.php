<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * @property string $id
 * @property string $redirect_url
 * @property bool $redirect_blanked
 */
class PacketRevisionRedirect extends BaseEntity
{
    /** @var string */
    protected $type = EntityType::PACKET_REVISION_REDIRECT;
}
