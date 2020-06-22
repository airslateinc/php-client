<?php

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Models\Document\DocumentFiles;

/**
 * Class Document
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $name
 * @property string $version
 * @property string $pdf_status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read File $pages
 * @property-read File $attributeFiles
 * @property-read Field[] $documentFields
 */

class Document extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::DOCUMENT;

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getPages()
    {
        return $this->hasOne(File::class, DocumentFiles::PAGES_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getAttributesFile()
    {
        return $this->hasOne(File::class, DocumentFiles::ATTRIBUTES_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getContent()
    {
        return $this->hasOne(File::class, DocumentFiles::CONTENT_FILE);
    }

    /**
     * @return Field[]
     * @throws \Exception
     */
    public function getDocumentFields(): array
    {
        return $this->hasMany(Field::class, 'fields');
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getFields()
    {
        return $this->hasOne(File::class, DocumentFiles::FIELDS_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getRoles()
    {
        return $this->hasOne(File::class, DocumentFiles::ROLES_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getComments()
    {
        return $this->hasOne(File::class, DocumentFiles::COMMENTS_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getOriginal()
    {
        return $this->hasOne(File::class, DocumentFiles::ORIGINAL_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getImage()
    {
        return $this->hasOne(File::class, DocumentFiles::IMAGE_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getPdf()
    {
        return $this->hasOne(File::class, DocumentFiles::PDF_FILE);
    }
}
