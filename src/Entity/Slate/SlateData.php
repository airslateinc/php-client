<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\Slate;

use AirSlate\ApiClient\Entity\AbstractData;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SlateData
 * @package AirSlate\ApiClient\Entity\Type
 */
class SlateData extends AbstractData
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\Slate\SlateAttributes")
     */
    protected $attributes;

    /**
     * Slate constructor.
     */
    public function __construct()
    {
        $this->type = 'slates';
    }

    /**
     * @return \AirSlate\ApiClient\Entity\Slate\SlateAttributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param \AirSlate\ApiClient\Entity\Slate\SlateAttributes $attributes
     */
    public function setAttributes($attributes): void
    {
        $this->attributes = $attributes;
    }
}
