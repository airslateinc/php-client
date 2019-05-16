<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

/**
 * Class InviteEmailAddition
 * @package AirSlate\ApiClient\Entities\Packets
 *
 * @property string $id
 * @property string $subject
 * @property string $text
 */
class InviteEmailAddition
{
    /**
     * @var string
     */
    public const DEFAULT_ID = 'generic_id';

    /**
     * @var string
     */
    public const RELATIONSHIP_KEY = 'invite_email_additions';

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $text;

    /**
     * InviteEmailAddition constructor.
     * @param string $subject
     * @param string $text
     */
    public function __construct(string $subject, string $text)
    {
        $this->subject = $subject;
        $this->text = $text;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
