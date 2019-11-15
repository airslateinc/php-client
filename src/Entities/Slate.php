<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\RelationNotExistException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;

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
 * @property-read User $admin
 */
class Slate extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::SLATE;

    /**
     * @return BaseEntity|User|null
     * @throws RelationNotExistException
     * @throws MissingDataException
     * @throws TypeMismatchException
     */
    public function getTemplate(): Template
    {
        return $this->hasOne(Template::class, 'template');
    }

    /**
     * @return BaseEntity|User|null
     * @throws RelationNotExistException
     * @throws MissingDataException
     * @throws TypeMismatchException
     */
    public function getAdmin(): User
    {
        return $this->hasOne(User::class, 'admins');
    }
}
