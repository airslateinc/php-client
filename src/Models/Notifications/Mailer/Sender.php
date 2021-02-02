<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Notifications\Mailer;

class Sender
{
    /** @var string */
    private $uid;

    /** @var string */
    private $organizationUid;

    /**
     * @param string $uid
     * @param string $organizationUid
     */
    public function __construct(string $uid, string $organizationUid)
    {
        $this->uid = $uid;
        $this->organizationUid = $organizationUid;
    }

    /**
     * @return string
     */
    public function uid(): string
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function organizationUid(): string
    {
        return $this->organizationUid;
    }
}
