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
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::DOCUMENT,
                'meta' => [
                    'password' => $this->password,
                ],
            ]
        ];
    }
}
