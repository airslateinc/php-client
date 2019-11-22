<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Entities\Permissions\MetaPermission;
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
 * @property-read MetaPermission $metaPermissions
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

    /**
     * @return BaseEntity|MetaPermission|null
     * @throws RelationNotExistException
     * @throws MissingDataException
     * @throws TypeMismatchException
     */
    public function getMetaPermissions()
    {
        return $this->hasOne(MetaPermission::class, 'meta_permissions');
    }
}
