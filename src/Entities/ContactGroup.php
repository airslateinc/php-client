<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Class ContactGroup
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $title
 */
class ContactGroup extends BaseEntity
{
    /** @var string */
    protected $type = EntityType::CONTACT_GROUP;
}
