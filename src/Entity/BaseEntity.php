<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class BaseEntity
 * @package AirSlate\ApiClient\Entity
 */
class BaseEntity
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\BaseData")
     */
    protected $data;

    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("array")
     */
    protected $included = [];

    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("array")
     */
    protected $meta = [];

    /**
     * @return \AirSlate\ApiClient\Entity\BaseData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \AirSlate\ApiClient\Entity\BaseData $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getIncluded(): array
    {
        return $this->included;
    }

    /**
     * @param $included
     */
    public function setIncluded($included): void
    {
        $this->included = $included;
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @param $meta
     */
    public function setMeta($meta): void
    {
        $this->meta = $meta;
    }
}
