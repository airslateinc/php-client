<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Experiment;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Helpers\ExperimentGuestIdGenerator;

/**
 * @property string $id
 * @property string $guest_id
 * @property string $user_agent
 */
class Guest extends BaseEntity
{
    protected $type = EntityType::GUEST;

    public static function createWithUserAgent(?string $userAgent): self
    {
        $guest = new self();
        $guest->setAttribute('guest_id', ExperimentGuestIdGenerator::generate());

        if ($userAgent !== null) {
            $guest->setAttribute('user_agent', $userAgent);
        }

        return $guest;
    }
}
