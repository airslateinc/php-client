<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;

use AirSlate\ApiClient\Entity\Slate\SlateData;
use JMS\Serializer\Annotation as Serializer;
use SignNow\Rest\EntityManager\Annotation\HttpEntity;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Entity
 *
 * @HttpEntity("slates/{id}")
 * @Serializer\ExclusionPolicy("all")
 */
class Slate extends BaseEntity
{
    /**
     * @var SlateData
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
     * @return SlateData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param SlateData $data
     * @return $this
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}
