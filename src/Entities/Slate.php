<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Template $template
 */
class Slate extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::SLATE;

    /**
     * @return BaseEntity|User|null
     * @throws \Exception
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, 'template');
    }
}
