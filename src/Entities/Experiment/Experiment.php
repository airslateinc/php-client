<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Experiment;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Entities\User;
use AirSlate\ApiClient\Exceptions\RelationNotExistException;
use Exception;

/**
 * @property string $id
 * @property string $experiment_uid
 * @property Branch|null $branch
 * @property User|null $user
 * @property Guest|null $guest
 */
class Experiment extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::EXPERIMENT;

    /**
     * @return Branch|null
     * @throws Exception
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::class, 'branches');
    }

    /**
     * @return User|null
     * @throws Exception
     */
    public function getUser()
    {
        return $this->hasOne(User::class, 'users');
    }

    /**
     * @return Guest|null
     * @throws Exception
     */
    public function getGuest()
    {
        return $this->hasOne(Guest::class, 'guests');
    }

    /**
     * Temporary backward compatibility hack
     * @param string $name
     * @return BaseEntity|mixed|null
     * @throws Exception
     */
    public function __get($name)
    {
        if ($name === 'branch') {
            return $this->getBranch();
        }

        return parent::__get($name);
    }

    /**
     * Nullable relations
     * @param string $className
     * @param string $relName
     * @return BaseEntity|null
     * @throws Exception
     */
    protected function hasOne(string $className, string $relName): ?BaseEntity
    {
        try {
            return parent::hasOne($className, $relName);
        } catch (RelationNotExistException $exception) {
            return null;
        }
    }
}
