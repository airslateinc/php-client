<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Paywall;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * @property string $id
 * @property string $name
 * @property string $price
 * @property int $level
 * @property string $code
 * @property string $status
 * @property string $duration
 * @property int $group
 * @property bool $is_free
 * @property string $type_payment_schedule
 * @property string $parent_id
 * @property string $created_at
 * @property string $updated_at
 */
class Plan extends BaseEntity
{
    protected $type = EntityType::PLANS;
}
