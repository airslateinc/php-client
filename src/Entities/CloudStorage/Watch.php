<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\CloudStorage;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * @property string $id
 * @property string $callback_url
 */
class Watch extends BaseEntity
{
    /** @var string */
    protected $type = EntityType::DATA_STORAGE_WATCH;

    /**
     * @return BaseEntity|Subscription|null
     */
    public function getSubscription(): ?Subscription
    {
        return $this->hasOne(Subscription::class, 'subscriptions');
    }
}
