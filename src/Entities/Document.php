<?php

namespace AirSlate\ApiClient\Entities;

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
        return $this->hasOne(File::class, 'pages_file');
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getAttributesFile()
    {
        return $this->hasOne(File::class, 'attributes_file');
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getContent()
    {
        return $this->hasOne(File::class, 'content_file');
    }

    /**
     * @return Field[]
     * @throws \Exception
     */
    public function getDocumentFields()
    {
        return $this->hasMany(Field::class, 'fields');
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getFields()
    {
        return $this->hasOne(File::class, 'fields_file');
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getRoles()
    {
        return $this->hasOne(File::class, 'roles_file');
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getComments()
    {
        return $this->hasOne(File::class, 'comments_file');
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getOriginal()
    {
        return $this->hasOne(File::class, 'original_file');
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getImage()
    {
        return $this->hasOne(File::class, 'image_file');
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getPdf()
    {
        return $this->hasOne(File::class, 'pdf_file');
    }
}
