<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Experiment;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * @property string $id
 * @property string $uid
 * @property string $name
 * @property int $percent
 * @property int $version
 * @property int $feature_flagging
 */
class Branch extends BaseEntity
{
    protected $type = EntityType::BRANCH;
}
