<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\Slate;

use AirSlate\ApiClient\Entity\BaseCollection;
use JMS\Serializer\Annotation as Serializer;
use SignNow\Rest\EntityManager\Annotation\HttpEntity;

/**
 * Class SlateCollection
 * @package AirSlate\ApiClient\Entity\Slate
 *
 * @HttpEntity("slates")
 * @Serializer\ExclusionPolicy("all")
 */
class SlateCollection extends BaseCollection
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("array<AirSlate\ApiClient\Entity\Slate\SlateData>")
     */
    protected $data;
}
