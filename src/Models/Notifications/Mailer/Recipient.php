<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Notifications\Mailer;

use InvalidArgumentException;

class Recipient
{
    /** @var string */
    private const TYPE_EMAIL = 'email';

    /** @var string */
    private const TYPE_USER = 'user_uid';

    /** @var string[] */
    private const ALLOWED_RECIPIENT_TYPES = [self::TYPE_EMAIL, self::TYPE_USER];

    /** @var string */
    private $type;

    /** @var string */
    private $value;

    /** @var string */
    private $name;

    /**
     * @param string $type
     * @param string $value
     * @param string $name
     */
    public function __construct(string $type, string $value, string $name)
    {
        if (!in_array($type, self::ALLOWED_RECIPIENT_TYPES, true)) {
            throw new InvalidArgumentException(sprintf(
                'Unknown recipient type! Only [%s] allowed',
                implode(',', self::ALLOWED_RECIPIENT_TYPES)
            ));
        }

        $this->type = $type;
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * @param string $email
     * @param string $name
     * @return self
     */
    public static function email(string $email, string $name): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }

        return new self(self::TYPE_EMAIL, $email, $name);
    }

    /**
     * @param string $userUid
     * @param string $name
     * @return self
     */
    public static function userUid(string $userUid, string $name): self
    {
        return new self(self::TYPE_USER, $userUid, $name);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
