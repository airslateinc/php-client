<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Contracts;

use GuzzleHttp\ClientInterface;

/**
 * Interface PoolInterface
 *
 * @package src\Contracts
 */
interface PoolInterface
{
    /**
     * Open pool
     */
    public function open(): void;
    
    /**
     * @return bool
     */
    public function isOpen(): bool;
    
    /**
     * @param \Closure $request
     * @param \Closure $callback
     */
    public function addRequest($request, $callback): void;
    
    /**
     * @param ClientInterface $client
     */
    public function send(ClientInterface $client): void;
    
    /**
     * @return array
     */
    public function getResponses(): array;
}
