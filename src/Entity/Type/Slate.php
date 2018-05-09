<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\Type;

use AirSlate\ApiClient\Entity\AbstractType;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Entity\Type
 */
class Slate extends AbstractType
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\Attribute\Slate")
     */
    protected $attributes;

    /**
     * @return \AirSlate\ApiClient\Entity\Attribute\Slate
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param \AirSlate\ApiClient\Entity\Attribute\Slate $attributes
     */
    public function setAttributes($attributes): void
    {
        $this->attributes = $attributes;
    }
}
