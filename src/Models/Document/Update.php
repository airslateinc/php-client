<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\Document;

/**
 * Class Update
 * @package AirSlate\ApiClient\Models\Document
 */
class Update extends Create
{
    public static function createFromDocument(Document $document, array $data = []): Create
    {
        $model = new static($data);
        $model->setName($document->getAttribute('name'));
        $model->setPagesCount($document->getObjectMetaAttribute('num_pages'));
        $model->setPagesCount($document->getObjectMetaAttribute('num_visible_pages'));
        return $model;
    }
}
