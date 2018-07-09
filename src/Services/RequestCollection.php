<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Contracts\RequestCollectionInterface;
use GuzzleHttp\ClientInterface;

/**
 * Class Pool
 *
 * @package AirSlate\ApiClient\Services
 */
class RequestCollection implements RequestCollectionInterface
{
    const DEFAULT_MAX_CONNECTIONS = 5;
    
    /**
     * @var array
     */
    protected $requests = [];
    
    /**
     * @var array
     */
    protected $responses = [];
    
    /**
     * @var array
     */
    protected $errors = [];
    
    /**
     * @var bool
     */
    private $isOpen = false;
    
    /**
     * @inheritdoc
     */
    public function open(): void
    {
        $this->isOpen = true;
        $this->clear();
    }
    
    /**
     * @inheritdoc
     */
    public function send(ClientInterface $client, $maxConnections = null): void
    {
        if (!$this->isOpen() || empty($this->requests)) {
            $this->close();
            throw new \LogicException('You must open Pool before send');
        }
        
        $requests = array_map(function ($element) {
            return $element['closure'];
        }, $this->requests);
        
        $options = [
            'concurrency' => $maxConnections ?: self::DEFAULT_MAX_CONNECTIONS,
            'fulfilled' => function (\GuzzleHttp\Psr7\Response $response, $index) {
                $this->responses[$index] = $response;
            },
            'rejected' => function (\Exception $reason, $index) {
                $this->errors[$index] = "Request number {$index} failed. Reason {$reason->getMessage()}";
            }
        ];
        
        $this->createPool($client, $requests, $options)->promise()->wait();
        $this->close();
        
        if (!empty($this->errors)) {
            $message = implode(" \n", $this->errors);
            $this->clear();
            
            throw new \RuntimeException($message);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function isOpen(): bool
    {
        return $this->isOpen;
    }
    
    /**
     * @inheritdoc
     */
    public function addRequest($request, $entityType): void
    {
        $this->requests[] = [
            'closure' => $request,
            'type' => $entityType,
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getResponses(): array
    {
        return $this->responses;
    }
    
    /**
     * Close pool
     */
    protected function close(): void
    {
        $this->isOpen = false;
    }
    
    /**
     * @param ClientInterface $client
     * @param array $requests
     * @param array $options
     *
     * @return \GuzzleHttp\Pool
     */
    protected function createPool(ClientInterface $client, array $requests, array $options)
    {
        return new \GuzzleHttp\Pool($client, $requests, $options);
    }
    
    /**
     * Clear pool
     */
    private function clear(): void
    {
        $this->errors = [];
        $this->requests = [];
        $this->responses = [];
    }
    
    /**
     * @inheritdoc
     */
    public function getEntityType(int $index): string
    {
        return $this->requests[$index]['type'];
    }
}
