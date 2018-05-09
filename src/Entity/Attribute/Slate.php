<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\Attribute;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Entity\Attribute
 */
class Slate
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $description;

    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $created_at;

    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $updated_at;

    /**
     * @return array
     */
    public function getName(): array
    {
        return $this->name;
    }

    /**
     * @param array $name
     */
    public function setName(array $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getDescription(): array
    {
        return $this->description;
    }

    /**
     * @param array $description
     */
    public function setDescription(array $description): void
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getCreatedAt(): array
    {
        return $this->created_at;
    }

    /**
     * @param array $created_at
     */
    public function setCreatedAt(array $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return array
     */
    public function getUpdatedAt(): array
    {
        return $this->updated_at;
    }

    /**
     * @param array $updated_at
     */
    public function setUpdatedAt(array $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
