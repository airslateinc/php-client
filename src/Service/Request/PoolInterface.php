<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Service\Request;

use AirSlate\ApiClient\Service\Request\Pool\Item;
use GuzzleHttp\ClientInterface;

/**
 * Interface PoolInterface
 *
 * @package src\Contracts
 */
interface PoolInterface
{
    /**
     * @param Item $item
     *
     * @return PoolInterface
     */
    public function add(Item $item): self;

    /**
     * @param int|null $concurecyLimit maximum number of parallel calls
     *
     * @return PoolInterface
     */
    public function send(int $concurecyLimit = null): self;
    
    /**
     * @return Item[]
     */
    public function getItems(): array;
}
