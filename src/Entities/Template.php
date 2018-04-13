<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class Template
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property int $version
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 */

class Template extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'templates';

    /**
     * @return array
     * @throws \Exception
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::class, 'documents');
    }
}
