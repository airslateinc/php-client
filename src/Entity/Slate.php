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
class Slate extends BaseEntity
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\Slate\SlateData")
     */
    protected $data;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getData()->getId();
    }

    /**
     * @return \AirSlate\ApiClient\Entity\Slate\SlateData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \AirSlate\ApiClient\Entity\Slate\SlateData $data
     * @return $this
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}
