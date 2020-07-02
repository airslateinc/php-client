<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\DTO\Notifications;

class ListPlaceholder extends AbstractPlaceholder
{
    /** @var string */
    private const TYPE = 'list';

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name, self::TYPE);

        $this->data['list'] = [];
    }

    /**
     * @param AbstractPlaceholder $placeholder
     * @return $this
     */
    public function addPlaceholder(AbstractPlaceholder $placeholder): self
    {
        $this->data['list'][] = $placeholder->toArray();

        return $this;
    }
}
