<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class AbstractEntity
 * @package AirSlate\ApiClient\Entity
 */
class AbstractEntity
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\AbstractType")
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
     * @return \AirSlate\ApiClient\Entity\AbstractType
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \AirSlate\ApiClient\Entity\AbstractType $data
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
