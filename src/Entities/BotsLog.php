<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Entities\Packets\Revision;
use AirSlate\ApiClient\Entities\Addons\SlateAddon;

class BotsLog extends BaseEntity
{
    /** @var string  */
    protected $type = EntityType::SLATE_ADDON_LOGS;

    /**
     * @return BaseEntity|null
     * @throws \Exception
     */
    public function getSlateAddon()
    {
        return $this->hasOne(SlateAddon::class, 'slate_addon');
    }

    /**
     * @return BaseEntity|null
     * @throws \Exception
     */
    public function getRevision()
    {
        return $this->hasOne(Revision::class, 'revision');
    }
}
