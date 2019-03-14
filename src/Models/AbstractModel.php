<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models;

/**
 * @package AirSlate\ApiClient\Models
 */
abstract class AbstractModel implements ArrayableInterface
{
    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => $this->data,
        ];
    }
}
