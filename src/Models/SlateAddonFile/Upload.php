<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\SlateAddonFile;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Upload extends AbstractModel
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $contents;

    /**
     * @var string
     */
    private $slateAddonUid;

    /**
     * @param string $filename
     * @param string $contents
     * @param string $slateAddonUid
     */
    public function __construct(string $filename, string $contents, string $slateAddonUid)
    {
        parent::__construct([]);
        $this->filename = $filename;
        $this->contents = $contents;
        $this->slateAddonUid = $slateAddonUid;
    }

    /**
     * @param string $name
     */
    public function setFilename(string $name): void
    {
        $this->filename = $name;
    }

    /**
     * @param string $val
     */
    public function setContents(string $val): void
    {
        $this->contents = $val;
    }

    /**
     * @param string $val
     */
    public function setSlateAddonUid(string $val): void
    {
        $this->slateAddonUid = $val;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::SLATE_ADDON_FILE,
                'attributes' => [
                    'filename' => $this->filename,
                    'content' => $this->contents
                ],
                'relationships' => [
                    'slate_addon' => [
                        'data' => [
                            'id' => $this->slateAddonUid,
                            'type' => EntityType::SLATE_ADDON
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Factory method.
     *
     * @param string $filename
     * @param string $contents
     * @param string $slateAddonUid
     * @return static
     */
    public static function make(string $filename, string $contents, string $slateAddonUid): self
    {
        return new static($filename, $contents, $slateAddonUid);
    }
}
