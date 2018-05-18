<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;

use AirSlate\ApiClient\Entity\User\UserData;
use JMS\Serializer\Annotation as Serializer;
use AirSlate\ApiClient\EntityManager\Annotation\HttpEntity;

/**
 * Class User
 * @package AirSlate\ApiClient\Entity
 *
 * @HttpEntity("organizations/{orgId}/users/{id}")
 * @Serializer\ExclusionPolicy("all")
 */
class User extends BaseEntity
{
    /**
     * @var SlateData
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\User\UserData")
     */
    protected $data;

    /**
     * @return UserData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param UserData $data
     * @return $this
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}
