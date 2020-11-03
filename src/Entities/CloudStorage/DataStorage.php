<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\CloudStorage;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * @property string $id
 * @property array $resource_information
 * @property array $resource_metadata
 */
class DataStorage extends BaseEntity
{
    /** @var string */
    protected $type = EntityType::DATA_STORAGE;
}
