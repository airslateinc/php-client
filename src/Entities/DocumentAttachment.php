<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\RelationNotExistException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;

/**
 * Class DocumentAttachment
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $type
 * @property string $subtype
 * @property string $meta
 * @property-read File|null $file
 */
class DocumentAttachment extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::DOCUMENT_ATTACHMENT;

    /**
     * @return File|null
     * @throws RelationNotExistException
     * @throws MissingDataException
     * @throws TypeMismatchException
     */
    public function getFile(): ?File
    {
        /** @var File|null */
        return $this->hasOne(File::class, 'file');
    }
}
