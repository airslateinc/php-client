<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Addons;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * @property string id
 * @property string name
 * @property string size
 * @property SlateAddon slateAddon
 *
 * @package AirSlate\ApiClient\Entities\Addons
 */
class SlateAddonFile extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::SLATE_ADDON_FILE;

    /**
     * @return SlateAddon
     */
    public function getSlateAddon(): SlateAddon
    {
        return $this->hasOne(SlateAddon::class, 'slate_addon');
    }
}
