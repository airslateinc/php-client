<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\User;

use AirSlate\ApiClient\Entity\BaseCollection;
use JMS\Serializer\Annotation as Serializer;
use AirSlate\ApiClient\Services\EntityManager\Annotation\HttpEntity;

/**
 * Class UserCollection
 * @package AirSlate\ApiClient\Entity\User
 *
 * @HttpEntity("organizations/{orgId}/users")
 * @Serializer\ExclusionPolicy("all")
 */
class UserCollection extends BaseCollection
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("array<AirSlate\ApiClient\Entity\User\UserData>")
     */
    protected $data;
}
