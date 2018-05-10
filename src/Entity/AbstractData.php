<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class AbstractType
 * @package AirSlate\ApiClient\Entity\Type
 */
class AbstractData
{
    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $type = '';

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $id = '';

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

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
