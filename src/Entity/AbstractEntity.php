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
     * @var object
     */
    protected $data;

    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("array")
     */
    protected $attributes = [];

    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("array")
     */
    protected $relationships = [];

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
     * @return object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getRelationships(): array
    {
        return $this->relationships;
    }

    /**
     * @param array $relationships
     * @return $this
     */
    public function setRelationships(array $relationships)
    {
        $this->relationships = $relationships;

        return $this;
    }

    /**
     * @return array
     */
    public function getIncluded(): array
    {
        return $this->included;
    }

    /**
     * @param array $included
     * @return $this
     */
    public function setIncluded(array $included)
    {
        $this->included = $included;

        return $this;
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @param array $meta
     * @return $this
     */
    public function setMeta(array $meta)
    {
        $this->meta = $meta;

        return $this;
    }
}
