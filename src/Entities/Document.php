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

    public const PAGES_FILE = 'pages_file';
    public const ATTRIBUTES_FILE = 'attributes_file';
    public const CONTENT_FILE = 'content_file';
    public const FIELDS_FILE = 'fields_file';
    public const ROLES_FILE = 'roles_file';
    public const COMMENTS_FILE = 'comments_file';
    public const ORIGINAL_FILE = 'original_file';
    public const IMAGE_FILE = 'image_file';
    public const PDF_FILE = 'pdf_file';
    public const DOC_GEN_CONTENT_FILE = 'doc_gen_content_file';
    public const DOC_GEN_FIELDS_FILE = 'doc_gen_fields_file';
    public const DOC_GEN_BLOCKS_FILE = 'doc_gen_blocks_file';
    public const FINAL_PDF_FILE = 'final_pdf_file';
    public const SIGNING_CERTIFICATE_PDF_FILE = 'signing_certificate_pdf_file';

    public const DOCUMENT_FILES = [
        self::PAGES_FILE,
        self::ATTRIBUTES_FILE,
        self::CONTENT_FILE,
        self::FIELDS_FILE,
        self::ROLES_FILE,
        self::COMMENTS_FILE,
        self::ORIGINAL_FILE,
        self::IMAGE_FILE,
        self::PDF_FILE,
        self::DOC_GEN_CONTENT_FILE,
        self::DOC_GEN_FIELDS_FILE,
        self::DOC_GEN_BLOCKS_FILE,
        self::FINAL_PDF_FILE,
        self::SIGNING_CERTIFICATE_PDF_FILE,
    ];

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getPages()
    {
        return $this->hasOne(File::class, self::PAGES_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getAttributesFile()
    {
        return $this->hasOne(File::class, self::ATTRIBUTES_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getContent()
    {
        return $this->hasOne(File::class, self::CONTENT_FILE);
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
        return $this->hasOne(File::class, self::FIELDS_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getRoles()
    {
        return $this->hasOne(File::class, self::ROLES_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getComments()
    {
        return $this->hasOne(File::class, self::COMMENTS_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getOriginal()
    {
        return $this->hasOne(File::class, self::ORIGINAL_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getImage()
    {
        return $this->hasOne(File::class, self::IMAGE_FILE);
    }

    /**
     * @return File|null
     * @throws \Exception
     */
    public function getPdf()
    {
        return $this->hasOne(File::class, self::PDF_FILE);
    }
}
