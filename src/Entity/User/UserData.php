<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\User;

use AirSlate\ApiClient\Entity\BaseData;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class UserData
 * @package AirSlate\ApiClient\Entity\User
 */
class UserData extends BaseData
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\User\UserAttributes")
     */
    protected $attributes;

    /**
     * Slate constructor.
     */
    public function __construct()
    {
        $this->type = 'users';
    }

    /**
     * @return UserAttributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param UserAttributes $attributes
     */
    public function setAttributes($attributes): void
    {
        $this->attributes = $attributes;
    }
}
