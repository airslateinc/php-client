<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Models\AbstractModel;

class DocumentEvent extends AbstractModel
{
    /** @var string */
    private $eventType;

    /** @var string */
    private $documentUid;

    /** @var string */
    private $fieldUid;

    /** @var string */
    private $fieldName;

    /** @var string */
    private $fieldValue;

    /** @var string */
    private $userUid;

    /** @var string */
    private $requestId;

    /**
     * @param string $eventType
     */
    public function setEventType(string $eventType): void
    {
        $this->eventType = $eventType;
    }

    /**
     * @param string $documentUid
     */
    public function setDocumentUid(string $documentUid): void
    {
        $this->documentUid = $documentUid;
    }

    /**
     * @param string $fieldUid
     */
    public function setFieldUid(string $fieldUid): void
    {
        $this->fieldUid = $fieldUid;
    }

    /**
     * @param string $fieldName
     */
    public function setFieldName(string $fieldName): void
    {
        $this->fieldName = $fieldName;
    }

    /**
     * @param string $fieldValue
     */
    public function setFieldValue(string $fieldValue): void
    {
        $this->fieldValue = $fieldValue;
    }

    /**
     * @param string $userUid
     */
    public function setUserUid(string $userUid): void
    {
        $this->userUid = $userUid;
    }

    /**
     * @param string $requestId
     */
    public function setRequestId(string $requestId): void
    {
        $this->requestId = $requestId;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => 'editor_events',
                'attributes' => [
                    'event_type' => $this->eventType,
                ],
                'relationships' => [
                    'document' => [
                        'data' => [
                            'id' => $this->documentUid,
                            'type' => 'documents'
                        ],
                    ],
                    'field' => [
                        'data' => [
                            'id' => $this->fieldUid,
                            'type' => 'editor_fields',
                        ],
                    ],
                    'viewer' => [
                        'data' => [
                            'id' => $this->userUid,
                            'type' => 'users',
                        ],
                    ],
                ]
            ],
            'included' => [
                [
                    'type' => 'editor_fields',
                    'id' => $this->fieldUid,
                    'attributes' => [
                        'name' => $this->fieldName,
                        'value' => $this->fieldValue,
                    ]
                ]
            ],
            'meta' => [
                'request_id' => $this->requestId,
            ],
        ];
    }
}
