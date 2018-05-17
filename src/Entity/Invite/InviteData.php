<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\Invite;

use AirSlate\ApiClient\Entity\BaseData;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class InviteData
 * @package AirSlate\ApiClient\Entity\Type
 */
class InviteData extends BaseData
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("array")
     */
    protected $attributes = [];

    /**
     * Slate constructor.
     */
    public function __construct()
    {
        $this->type = 'users';
    }
}
