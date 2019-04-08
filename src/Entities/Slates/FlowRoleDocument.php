<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Slates;

use AirSlate\ApiClient\Entities\BaseEntity;

/**
 * Class FlowRoleDocument
 * @package AirSlate\ApiClient\Entities\Slates
 *
 * @property string $id
 * @property array $config
 * @property string $fields
 */
class FlowRoleDocument extends BaseEntity
{
    protected $type = 'flow_role_documents';
}
