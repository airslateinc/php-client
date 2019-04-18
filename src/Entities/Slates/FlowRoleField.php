<?php

namespace AirSlate\ApiClient\Entities\Slates;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\Slate;
use AirSlate\ApiClient\Entities\Document;

/**
 * Class FlowRoleField
 * @package AirSlate\ApiClient\Entities\Slates
 *
 * @property string $id
 * @property bool $lock_unmapped_fields
 * @property array $fields
 */
class FlowRoleField extends BaseEntity
{
    protected $type = 'flow_role_fields';

    /**
     * @return Slate|null
     * @throws \Exception
     */
    public function getFlow(): ?Slate
    {
        return $this->hasOne(Slate::class, 'flow');
    }

    /**
     * @return FlowRole|null
     * @throws \Exception
     */
    public function getRole(): ?FlowRole
    {
        return $this->hasOne(FlowRole::class, 'role');
    }

    /**
     * @return Document|null
     * @throws \Exception
     */
    public function getTemplateDocument(): ?Document
    {
        return $this->hasOne(Document::class, 'template_document');
    }
}