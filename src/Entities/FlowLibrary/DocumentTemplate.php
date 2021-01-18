<?php

namespace AirSlate\ApiClient\Entities\FlowLibrary;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\File;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * Class DocumentTemplate
 * @package AirSlate\ApiClient\Entities\FlowLibrary
 *
 * @property string $id
 * @property string $title
 * @property-read File $template
 */
class DocumentTemplate extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::DOCUMENT_TEMPLATE;

    /**
     * @return File|null
     */
    public function getTemplate(): ?File
    {
        return $this->hasOne(File::class, 'template_file');
    }
}
