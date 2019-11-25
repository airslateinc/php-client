<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Entities\Packets\Revision;
use AirSlate\ApiClient\Entities\Addons\SlateAddon;

/**
 * Class AddonLog
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property-read SlateAddon|null $slateAddon
 * @property-read Revision|null $revision
 */
class AddonLog extends BaseEntity
{
    /** @var string  */
    protected $type = EntityType::SLATE_ADDON_LOG;

    /**
     * @return BaseEntity|SlateAddon|null
     * @throws \Exception
     */
    public function getSlateAddon(): ?SlateAddon
    {
        return $this->hasOne(SlateAddon::class, 'slate_addon');
    }

    /**
     * @return BaseEntity|Revision|null
     * @throws \Exception
     */
    public function getRevision(): ?Revision
    {
        return $this->hasOne(Revision::class, 'revision');
    }
}
