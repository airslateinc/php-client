<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Notifications\Mailer;

class NotificationMail
{
    /** @var string */
    private const DEFAULT_GROUP = 'airslate';

    /** @var Recipient */
    private $recipient;

    /** @var string */
    private $templateName;

    /** @var array */
    private $templateParams;

    /** @var string */
    private $group;

    /** @var string|null */
    private $subject;

    /** @var Sender|null */
    private $sender;

    /**
     * @param Recipient $recipient
     * @param string $templateName
     * @param array $templateParams
     * @param string $group
     * @param string|null $subject
     * @param Sender|null $sender
     */
    public function __construct(
        Recipient $recipient,
        string $templateName,
        array $templateParams,
        string $group = self::DEFAULT_GROUP,
        ?string $subject = null,
        ?Sender $sender = null
    ) {
        $this->recipient = $recipient;
        $this->sender = $sender;
        $this->templateName = $templateName;
        $this->templateParams = $templateParams;
        $this->subject = $subject;
        $this->group = $group;
    }

    /**
     * @return string
     */
    public function templateName(): string
    {
        return $this->templateName;
    }

    /**
     * @return array
     */
    public function templateParams(): array
    {
        return $this->templateParams;
    }

    /**
     * @return string|null
     */
    public function subject(): ?string
    {
        return $this->subject;
    }

    /**
     * @return Recipient
     */
    public function recipient(): Recipient
    {
        return $this->recipient;
    }

    /**
     * @return Sender|null
     */
    public function sender(): ?Sender
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function group(): string
    {
        return $this->group;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $recipient = $this->recipient();
        $sender = $this->sender();

        $mail = [
            'to' => [
                'name' => $recipient->name(),
                $recipient->type() => $recipient->value(),
            ],
            'template' => [
                'name' => $this->templateName(),
                'params' => $this->templateParams(),
            ],
            'group' => $this->group(),
        ];

        if ($this->subject() !== null) {
            $mail['subject'] = $this->subject();
        }

        $mailAttributes = ['mail_payload' => $mail];

        if ($sender !== null) {
            $mailAttributes['sender_uid'] = $sender->uid();
            $mailAttributes['organization_uid'] = $sender->organizationUid();
        }

        return $mailAttributes;
    }
}
