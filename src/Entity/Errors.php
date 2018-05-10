<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Errors
 * @package AirSlate\ApiClient\Entity
 *
 * @Serializer\ExclusionPolicy("all")
 * @todo It should be implemented as collection
 */
class Errors
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("array")
     */
    protected $errors;

    /**
     * @return \AirSlate\ApiClient\Entity\Slate\SlateData
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
