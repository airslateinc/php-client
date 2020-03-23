<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\RelationNotExistException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;

/**
 * Class SlateInvite
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $email
 * @property string $access
 * @property bool   $ignored
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read User|null $user
 */
class SlateInvite extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::SLATE_INVITE;

    /**
     * @return BaseEntity|User|null
     * @throws RelationNotExistException
     * @throws MissingDataException
     * @throws TypeMismatchException
     */
    public function getUser(): ?User
    {
        return $this->hasOne(User::class, 'users');
    }
}
