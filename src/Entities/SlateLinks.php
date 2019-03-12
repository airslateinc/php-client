<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class SlateLinks
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $open_link
 */
class SlateLinks extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::SLATE_LINKS;
}
