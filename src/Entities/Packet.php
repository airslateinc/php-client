<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class Packet
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $versions
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 */

class Packet extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'packets';

    /**
     * @return array
     * @throws \Exception
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::class, 'documents');
    }
}
