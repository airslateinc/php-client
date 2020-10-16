<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\SlateAddon;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class ResolveTags extends AbstractModel
{
    /** @var array */
    protected $tags;

    /** @var string */
    protected $flowUid;

    /** @var string */
    protected $packetUid;

    /** @var string */
    protected $revisionUid;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::RESOLVE_TAGS,
                'attributes' => [
                    'tags' => $this->tags,
                ],
                'relationships' => [
                    'slate' => [
                        'data' => [
                            'id' => $this->flowUid,
                            'type' => EntityType::SLATE,
                        ],
                    ],
                    'packet' => [
                        'data' => [
                            'id' => $this->packetUid,
                            'type' => EntityType::PACKET,
                        ],
                    ],
                    'packet_revision' => [
                        'data' => [
                            'id' => $this->revisionUid,
                            'type' => EntityType::PACKET_REVISION,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param string $revisionUid
     * @param array $tags
     * @return static
     */
    public static function fromTags(
        string $flowUid,
        string $packetUid,
        string $revisionUid,
        array $tags
    ): self {
        $model = new self();
        $model->flowUid = $flowUid;
        $model->packetUid = $packetUid;
        $model->revisionUid = $revisionUid;
        $model->tags = $tags;

        return $model;
    }
}
