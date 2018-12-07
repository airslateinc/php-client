<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Contracts;

use GuzzleHttp\ClientInterface;

/**
 * Interface PoolInterface
 *
 * @package src\Contracts
 */
interface RequestCollectionInterface
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
     * @param string $entityType
     */
    public function addRequest($request, $entityType): void;
    
    /**
     * @param ClientInterface $client
     * @param integer|null $maxConnections
     */
    public function send(ClientInterface $client, $maxConnections = null): void;
    
    /**
     * @return array
     */
    public function getResponses(): array;
    
    /**
     * @param integer $index
     *
     * @return string
     */
    public function getEntityType(int $index): string;
}
