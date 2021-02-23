<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\PacketRevisionRedirects;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
{
    /** @var string */
    private $redirectUrl;

    /** @var bool */
    private $redirectBlanked;

    public function __construct(string $redirectUrl, bool $redirectBlanked)
    {
        parent::__construct();

        $this->redirectUrl = $redirectUrl;
        $this->redirectBlanked = $redirectBlanked;
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'type' => EntityType::PACKET_REVISION_REDIRECT,
                'attributes' => [
                    'redirect_url' => $this->redirectUrl,
                    'redirect_blanked' => $this->redirectBlanked,
                ],
            ],
        ];
    }
}
