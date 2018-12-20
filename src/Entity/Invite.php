<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;

use AirSlate\ApiClient\Entity\Invite\InviteData;
use JMS\Serializer\Annotation as Serializer;
use SignNow\Rest\EntityManager\Annotation\HttpEntity;
use SignNow\Rest\EntityManager\Annotation\ResponseType;

/**
 * Class Invite
 * @package AirSlate\ApiClient\Entity
 *
 * @HttpEntity("organizations/{orgId}/users/invite")
 * @ResponseType("AirSlate\ApiClient\Entity\User\UserCollection")
 * @Serializer\ExclusionPolicy("all")
 */
class Invite extends BaseEntity
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\Invite\InviteData")
     */
    protected $data;

    /**
     * Invite constructor.
     */
    public function __construct()
    {
        $this->data = new InviteData();
    }

    /**
     * @param string $email
     * @return $this
     */
    public function addEmail(string $email)
    {
        $attributes = $this->getData()->getAttributes();
        if (array_key_exists('emails', $attributes) === false) {
            $attributes['emails'] = [];
        }
        $attributes['emails'][] = $email;
        $this->getData()->setAttributes($attributes);

        return $this;
    }
}
