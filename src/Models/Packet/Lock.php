<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

class Lock
{
    /**
     * @var string
     */
    public const STATUS_ACTIVE = 'ACTIVE';

    /**
     * @var string
     */
    public const STATUS_LOCKED = 'LOCKED';

    /**
     * @var string
     */
    private $status;

    /**
     * @param string $status
     * @return Lock
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => 'packets',
                'attributes' => [
                    'status' =>  $this->status
                ]
            ],
        ];
    }
}
