<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Packets;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\Document;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * Class RevisionDocument
 * @package AirSlate\ApiClient\Entities\Packets
 *
 * @property string $id
 * @property bool $hidden
 * @property string $created_at
 * @property string $updated_at
 */
class RevisionDocument extends BaseEntity
{
    protected $type = EntityType::PACKET_REVISION_DOCUMENT;

    /**
     * @return BaseEntity|Document|null
     * @throws \Exception
     */
    public function getDocument()
    {
        return $this->hasOne(Document::class, 'document');
    }

    /**
     * @return string|null
     */
    public function getDocumentId()
    {
        $relationships = $this->getRelationships();

        if (!empty($relationships['document']['data']['id'])) {
            return $relationships['document']['data']['id'];
        }

        return null;
    }

    /**
     * @return BaseEntity|Document|null
     * @throws \Exception
     */
    public function getTemplateDocument()
    {
        return $this->hasOne(Document::class, 'template_document');
    }

    /**
     * @return string|null
     */
    public function getTemplateDocumentId()
    {
        $relationships = $this->getRelationships();

        if (!empty($relationships['template_document']['data']['id'])) {
            return $relationships['template_document']['data']['id'];
        }

        return null;
    }
}
