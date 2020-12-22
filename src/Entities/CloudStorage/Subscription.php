<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\CloudStorage;

use AirSlate\ApiClient\Entities\BaseEntity;

/**
 * @property string $id
 * @property string $resource_identifier
 * @property string $resource_type
 * @property string $subscription_identifier
 * @property array $settings
 * @property string $expires_on
 */
class Subscription  extends BaseEntity
{
    /** @var string */
    protected $type = 'subscriptions';
}
