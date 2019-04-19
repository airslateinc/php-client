<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Slates;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Entities\Slate;

/**
 * Class FlowRole
 * @package AirSlate\ApiClient\Entities\Slates
 *
 * @property string $id
 * @property string $name
 */
class FlowRole extends BaseEntity
{
    protected $type = EntityType::FLOW_ROLE;

    /**
     * @return Slate|null
     * @throws \Exception
     */
    public function getFlow(): ?Slate
    {
        return $this->hasOne(Slate::class, 'flow');
    }
}
