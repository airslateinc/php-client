<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\CloudStorage;

use AirSlate\ApiClient\Entities\BaseEntity;

class DataProvideResponse extends BaseEntity
{
    /** @var string */
    protected $type = 'data_provide_response';

    /**
     * @return Entity[]
     */
    public function getEntities(): array
    {
        return $this->hasMany(Entity::class, 'entities');
    }
}
