<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Notifications\Mailer;

class Attachments
{
    /** @var array */
    private $attachments = [];

    /**
     * @param string $filename
     * @param string $name
     * @param string $contents
     */
    public function addAttachment(string $filename, string $name, string $contents): void
    {
        $this->attachments[] = [
            'filename' => $filename,
            'name' => $name,
            'contents' => base64_encode($contents),
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->attachments;
    }
}
