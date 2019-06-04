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

    /**
     * @var ActiveModebarTab
     */
    private $activeModebarTab;

    public function __construct(
        EnableComments $enableComments,
        EnableToolbar $enableToolbar,
        ActiveModebarTab $activeModebarTab
    ) {
        $this->enableComments = $enableComments;
        $this->enableToolbar = $enableToolbar;
        $this->activeModebarTab = $activeModebarTab;
    }

    public function enableComments(): EnableComments
    {
        return $this->enableComments;
    }

    public function enableToolbar(): EnableToolbar
    {
        return $this->enableToolbar;
    }

    public function activeModebarTab(): ActiveModebarTab
    {
        return $this->activeModebarTab;
    }

    public function toArray(): array
    {
        return [
            'enable_comments' => $this->enableComments->toArray(),
            'enable_toolbar' => $this->enableToolbar->toArray(),
            'active_modebar_tab' => $this->activeModebarTab->toArray(),
        ];
    }

    public static function createDefault(): self
    {
        return new self(
            new EnableComments,
            new EnableToolbar,
            new ActiveModebarTab
        );
    }
}
