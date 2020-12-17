<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\SlateInvite;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    /** @var string */
    private $email;

    /** @var string */
    private $access;

    /** @var bool */
    private $hasCountGroup;

    public function __construct(string $email, string $access, bool $hasCountGroup)
    {
        parent::__construct([]);
        $this->email = $email;
        $this->access = $access;
        $this->hasCountGroup = $hasCountGroup;
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::SLATE_INVITE,
                'attributes' => [
                    'email' => $this->email,
                    'access' => $this->access,
                    'hasCountGroup' => $this->hasCountGroup,
                ],
            ],
        ];
    }
}
