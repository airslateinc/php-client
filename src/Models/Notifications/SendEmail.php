<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Notifications;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;
use AirSlate\ApiClient\Models\Notifications\Mailer\Attachments;
use AirSlate\ApiClient\Models\Notifications\Mailer\NotificationMail;

class SendEmail extends AbstractModel
{
    /** @var NotificationMail */
    private $mail;

    /** @var Attachments */
    private $attachments;

    /**
     * @param NotificationMail $mail
     * @param Attachments|null $attachments
     */
    public function __construct(NotificationMail $mail, Attachments $attachments = null)
    {
        parent::__construct();

        $this->mail = $mail;
        $this->attachments = $attachments;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $attributes = $this->mail->toArray();

        if ($this->attachments !== null) {
            $attributes['attachments'] = $this->attachments->toArray();
        }

        return [
            'data' => [
                'type' => EntityType::NOTIFICATION_MAIL,
                'attributes' => $attributes,
            ]
        ];
    }
}
