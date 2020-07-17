<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

class PacketRevision extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::PACKET_REVISION;

    /**
     * @return Document[]
     * @throws \Exception
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::class, 'documents');
    }
}
