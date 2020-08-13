<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Export
 *
 * @package AirSlate\ApiClient\Models\Document
 */
class ExportSms extends AbstractModel
{
    /** @var string*/
    private $name;

    /** @var array*/
    private $recipients;

    /**
     * @param string $name
     * @return ExportSms|static
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param array $recipients
     * @return ExportSms|static
     */
    public function setRecipients(array $recipients): self
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $recipients = array_map(function ($recipient) {
            return ['number' => $recipient];
        }, $this->recipients);

        return [
            'data' => [
                'type' => EntityType::ENVELOPE_SMS,
                'attributes' =>
                    [
                        'name' => $this->name,
                        'recipients' => $recipients
                    ]
            ],
        ];
    }
}
