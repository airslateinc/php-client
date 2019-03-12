<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class DocumentAttachment
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $type
 * @property string $subtype
 * @property string $meta
 */
class DocumentAttachment extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::DOCUMENT_ATTACHMENT;
}
