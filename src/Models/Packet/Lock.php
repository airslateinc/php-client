<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

use AirSlate\ApiClient\Exceptions\DomainException;

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
     * @var array
     */
    private const ATTRIBUTES = ['status', 'lock_after_signing_order'];

    /**
     * @var string
     */
    private $status;

    /**
     * @var bool
     */
    private $lock_after_signing_order;

    /**
     * @param string $status
     * @return Lock
     */
    public function setStatus(string $status): self
    {
        if (!in_array($status, [self::STATUS_LOCKED, self::STATUS_ACTIVE])) {
            throw new DomainException('Status "' . $status . '" is not allowed');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * @param bool $lockAfterSigningOrder
     * @return Lock
     */
    public function setLockAfterSigningOrder(bool $lockAfterSigningOrder): self
    {
        $this->lock_after_signing_order = $lockAfterSigningOrder;

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
                'attributes' => $this->getAttributes()
            ],
        ];
    }

    /**
     * @return array
     */
    private function getAttributes(): array
    {
        $attributes = array_reduce(self::ATTRIBUTES, function ($attributes, $property) {
            if ($this->{$property} !== null) {
                $attributes[$property] = $this->{$property};
            }

            return $attributes;
        }, []);

        if (!count($attributes)) {
            throw new DomainException('Send attributes are not defined');
        }

        return $attributes;
    }
}
