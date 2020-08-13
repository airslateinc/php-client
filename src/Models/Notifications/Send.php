<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Notifications;

use AirSlate\ApiClient\DTO\Notifications\AbstractPlaceholder;
use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Send extends AbstractModel
{
    /**
     * @param string $userId
     * @param string $message
     */
    public function __construct(string $userId, string $message)
    {
        $data = [
            'type' => EntityType::NOTIFICATION,
            'attributes' => [
                'custom_template' => $message,
                'message' => [
                    'placeholders' => []
                ]
            ],
            'relationships' => [
                'recipient' => [
                    'data' => [
                        'type' => EntityType::USER,
                        'id' => $userId
                    ]
                ]
            ]
        ];

        parent::__construct($data);
    }

    /**
     * @param AbstractPlaceholder $placeholder
     * @return $this
     */
    public function addPlaceholder(AbstractPlaceholder $placeholder): self
    {
        $this->data['attributes']['message']['placeholders'][$placeholder->getName()] = $placeholder->toArray();

        return $this;
    }
}
