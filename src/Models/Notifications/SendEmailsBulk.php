<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Notifications;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;
use AirSlate\ApiClient\Models\Notifications\Mailer\NotificationMail;

class SendEmailsBulk extends AbstractModel
{
    /**
     * @param NotificationMail ...$mails
     */
    public function __construct(NotificationMail ...$mails)
    {
        parent::__construct();

        foreach ($mails as $mail) {
            $this->addMail($mail);
        }
    }

    /**
     * @param NotificationMail $mail
     */
    public function addMail(NotificationMail $mail): void
    {
        $this->data[] = [
            'type' => EntityType::NOTIFICATION_MAIL,
            'attributes' => $mail->toArray(),
        ];
    }
}
