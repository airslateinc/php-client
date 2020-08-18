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
 * @property string|null $customTitle
 * @property string|null $customPreheader
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
    public const RELATIONSHIP_KEY_NEW = 'invite_email_addition';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string|null
     */
    private $customTitle;

    /**
     * @var string|null
     */
    private $customPreheader;

    /**
     * InviteEmailAddition constructor.
     *
     * @param string      $id
     * @param string      $subject
     * @param string      $text
     * @param string|null $customTitle
     * @param string|null $customPreheader
     */
    public function __construct(
        string $id,
        string $subject,
        string $text,
        ?string $customTitle = null,
        ?string $customPreheader = null
    ) {
        $this->id = $id;
        $this->subject = $subject;
        $this->text = $text;
        $this->customTitle = $customTitle;
        $this->customPreheader = $customPreheader;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCustomTitle(): ?string
    {
        return $this->customTitle;
    }

    /**
     * @return string|null
     */
    public function getCustomPreheader(): ?string
    {
        return $this->customPreheader;
    }
}
