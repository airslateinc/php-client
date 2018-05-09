<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class AbstractType
 * @package AirSlate\ApiClient\Entity\Type
 */
class AbstractType
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $type;

    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $id;

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
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     * @param array $relationships
     */
    public function setRelationships($relationships): void
    {
        $this->relationships = $relationships;
    }
}
