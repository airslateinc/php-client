<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\Slate;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SlateAttributes
 * @package AirSlate\ApiClient\Entity\Slate
 */
class SlateAttributes
{
    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $description;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $created_at;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $updated_at;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(array $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
