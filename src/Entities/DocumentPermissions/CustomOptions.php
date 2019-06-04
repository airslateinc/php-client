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
     * @var ActiveTab
     */
    private $activeTab;

    public function __construct(
        EnableComments $enableComments,
        EnableToolbar $enableToolbar,
        ActiveTab $activeTab
    ) {
        $this->enableComments = $enableComments;
        $this->enableToolbar = $enableToolbar;
        $this->activeTab = $activeTab;
    }

    public function enableComments(): EnableComments
    {
        return $this->enableComments;
    }

    public function enableToolbar(): EnableToolbar
    {
        return $this->enableToolbar;
    }

    public function activeTab(): ActiveTab
    {
        return $this->activeTab;
    }

    public function toArray(): array
    {
        return [
            'enable_comments' => $this->enableComments->toArray(),
            'enable_toolbar' => $this->enableToolbar->toArray(),
            'active_modebar_tab' => $this->activeTab->toArray(),
        ];
    }

    public static function createDefault(): self
    {
        return new self(
            new EnableComments,
            new EnableToolbar,
            new ActiveTab
        );
    }
}
