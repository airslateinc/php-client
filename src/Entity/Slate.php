<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;

use JMS\Serializer\Annotation as Serializer;
use AirSlate\ApiClient\Services\EntityManager\Annotation\HttpEntity;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Entity
 *
 * @HttpEntity("slates")
 * @Serializer\ExclusionPolicy("all")
 */
class Slate extends AbstractEntity
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\Type\Slate")
     */
    protected $data;

    /**
     * @return \AirSlate\ApiClient\Entity\Type\Slate
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \AirSlate\ApiClient\Entity\Type\Slate $data
     * @return $this
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}
