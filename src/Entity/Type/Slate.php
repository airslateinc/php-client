<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\Type;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Slate
 * @package AirSlate\ApiClient\Entity\Type
 */
class Slate
{
    /**
     * @var integer
     *
     * @Serializer\Expose()
     * @Serializer\Type("integer")
     */
    private $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
