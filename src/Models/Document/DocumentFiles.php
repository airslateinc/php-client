<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Models\AbstractModel;
use InvalidArgumentException;

/**
 * Class DocumentFiles
 * @package AirSlate\ApiClient\Models\Document
 */
class DocumentFiles extends AbstractModel
{
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
     * @param string $type
     * @param string $name
     * @param string $content
     */
    public function addFile(string $type, string $name, string $content): void
    {
        if (!in_array($type, self::DOCUMENT_FILES)) {
            throw new InvalidArgumentException(sprintf('Unsupported document file type: %s', $type));
        }

        $this->data[] = [
            'type' => $type,
            'attributes' => [
                'name' => $name,
                'file' => base64_encode($content),
            ]
        ];
    }
}
