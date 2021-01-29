<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Notifications;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class SendEmailsBulk extends AbstractModel
{
    /**
     * @param array $mails
     */
    public function __construct(array $mails)
    {
        parent::__construct();

        foreach ($mails as $mail) {
            $this->addMail($mail);
        }
    }

    /**
     * @param array $mail
     */
    public function addMail(array $mail): void
    {
        $this->data[] = [
            'type' => EntityType::NOTIFICATION_MAIL,
            'attributes' => $mail,
        ];
    }
}
