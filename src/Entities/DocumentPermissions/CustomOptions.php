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
     * @var ShowConstructor
     */
    private $showConstructor;

    public function __construct(
        EnableComments $enableComments,
        EnableToolbar $enableToolbar,
        ShowConstructor $showConstructor
    ) {
        $this->enableComments = $enableComments;
        $this->enableToolbar = $enableToolbar;
        $this->showConstructor = $showConstructor;
    }

    public function enableComments(): EnableComments
    {
        return $this->enableComments;
    }

    public function enableToolbar(): EnableToolbar
    {
        return $this->enableToolbar;
    }

    public function showConstructor(): ShowConstructor
    {
        return $this->showConstructor;
    }

    public function toArray(): array
    {
        return [
            'enable_comments' => $this->enableComments->toArray(),
            'enable_toolbar' => $this->enableToolbar->toArray(),
            'show_constructor' => $this->showConstructor->toArray(),
        ];
    }

    public static function createDefault(): self
    {
        return new self(
            new EnableComments,
            new EnableToolbar,
            new ShowConstructor
        );
    }
}
