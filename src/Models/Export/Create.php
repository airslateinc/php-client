<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Export;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Create
 *
 * @package AirSlate\ApiClient\Models\Export
 */
class Create extends AbstractModel
{
    protected $documents;

    public function __construct(array $data = [])
    {
        $data = array_merge_recursive([
            'type' => EntityType::EXPORT,
            'attributes' => [
                'type' => 'zip',
                'render_text_only' => false,
            ],
        ], $data);
        parent::__construct($data);
    }

    /**
     * @param string $id
     * @param array|null $pages
     * @return Create
     */
    public function addDocument(string $id, array $pages = null): self
    {
        $document = [
            'id' => $id,
            'type' => EntityType::DOCUMENT,
        ];
        if (!is_null($pages)) {
            $document['meta']['pages'] = $pages;
        }
        $this->data['relationships']['documents']['data'][] = $document;
        return $this;
    }

    public function setPacket(string $id): self
    {
        $this->data['relationships']['packet']['data'] = [
            'type' => EntityType::PACKET,
            'id' => $id,
        ];
        return $this;
    }

    public function setRevision(string $id): self
    {
        $this->data['relationships']['packet_revision']['data'] = [
            'type' => EntityType::PACKET_REVISION,
            'id' => $id,
        ];
        return $this;
    }

    public function setSlate(string $id): self
    {
        $this->data['relationships']['slate']['data'] = [
            'type' => EntityType::SLATE,
            'id' => $id,
        ];
        return $this;
    }

    public function type(string $type): self
    {
        $this->data['attributes']['type'] = $type;
        return $this;
    }

    public function documentFormat(string $format): self
    {
        $this->data['attributes']['document_format'] = $format;
        return $this;
    }

    public function password(string $password): self
    {
        $this->data['attributes']['password'] = $password;
        return $this;
    }

    public function renderTextOnly(bool $flag): self
    {
        $this->data['attributes']['render_text_only'] = $flag;
        return $this;
    }

    public function toArray(): array
    {
        return ['data' => $this->data];
    }

    public function appName(string $appName): self
    {
        $this->data['meta']['app_name'] = $appName;
        return $this;
    }
}
