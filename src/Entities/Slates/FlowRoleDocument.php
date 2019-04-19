<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Slates;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Entities\Slate;
use AirSlate\ApiClient\Entities\Document;

/**
 * Class FlowRoleDocument
 * @package AirSlate\ApiClient\Entities\Slates
 *
 * @property string $id
 * @property array $config
 * @property array $fields
 */
class FlowRoleDocument extends BaseEntity
{
    protected $type = EntityType::FLOW_ROLE_DOCUMENT;

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
