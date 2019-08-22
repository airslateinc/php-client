<?php

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class UnlockPdf extends AbstractModel
{
    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $documentId;

    /**
     * @param string $password
     *
     * @return UnlockPdf
     */
    public function setPassword(string $password): UnlockPdf
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return UnlockPdf
     */
    public function setDocument(string $id): UnlockPdf
    {
        $this->documentId = $id;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'id' => $this->documentId,
                'type' => EntityType::DOCUMENT,
                'meta' => [
                    'password' => $this->password,
                ],
            ]
        ];
    }
}