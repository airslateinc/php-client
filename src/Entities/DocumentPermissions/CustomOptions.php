<?php

declare(strict_types=1);

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
     * @var ShowConstructor
     */
    private $showConstructor;

    /**
     * @param EnableComments $enableComments
     * @param EnableToolbar $enableToolbar
     * @param ShowConstructor $showConstructor
     */
    public function __construct(
        EnableComments $enableComments,
        EnableToolbar $enableToolbar,
        ShowConstructor $showConstructor
    ) {
        $this->enableComments = $enableComments;
        $this->enableToolbar = $enableToolbar;
        $this->showConstructor = $showConstructor;
    }

    /**
     * @return EnableComments
     */
    public function enableComments(): EnableComments
    {
        return $this->enableComments;
    }

    /**
     * @return EnableToolbar
     */
    public function enableToolbar(): EnableToolbar
    {
        return $this->enableToolbar;
    }

    /**
     * @return ShowConstructor
     */
    public function showConstructor(): ShowConstructor
    {
        return $this->showConstructor;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'enable_comments' => $this->enableComments->toArray(),
            'enable_toolbar' => $this->enableToolbar->toArray(),
            'show_constructor' => $this->showConstructor->toArray(),
        ];
    }

    /**
     * @return static
     */
    public static function createDefault(): self
    {
        return new self(
            new EnableComments(),
            new EnableToolbar(),
            new ShowConstructor()
        );
    }
}
