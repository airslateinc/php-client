<?php
declare(strict_types = 1);

namespace AirSlate\ApiClient\Entities\DocumentPermissions;

class CustomOptions
{
    /**
     * @var EnableComments
     */
    private $enableComments;

    /**
     * @var EnableToolbar
     */
    private $enableToolbar;

    public function __construct(
        EnableComments $enableComments,
        EnableToolbar $enableToolbar
    ) {
        $this->enableComments = $enableComments;
        $this->enableToolbar = $enableToolbar;
    }

    public function enableComments(): EnableComments
    {
        return $this->enableComments;
    }

    public function enableToolbar(): EnableToolbar
    {
        return $this->enableToolbar;
    }

    public function toArray(): array
    {
        return [
            'enable_comments' => $this->enableComments->toArray(),
            'enable_toolbar' => $this->enableToolbar->toArray(),
        ];
    }

    public static function createDefault(): self
    {
        return new self(
            new EnableComments,
            new EnableToolbar
        );
    }
}
