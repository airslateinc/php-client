<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property array $editor_options
 */
class EditorOptions extends BaseEntity
{
    /** @var string */
    protected $type = EntityType::EDITOR_OPTIONS;
}
