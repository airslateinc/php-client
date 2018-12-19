<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Service\Request;

use AirSlate\ApiClient\Service\Request\Pool\Item;
use GuzzleHttp\ClientInterface;

/**
 * Class Pool
 *
 * @package AirSlate\ApiClient\Services\Request
 */
class Pool implements PoolInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Item[]
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * Pool constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function send(int $concurencyLimit = null): PoolInterface
    {
        if (empty($this->items)) {
            throw new \LogicException('Please add items to request pool first');
        }
        
        $requests = array_map(function (Item $item) {
            return $item->getClosure();
        }, $this->items);
        
        $options = [
            'fulfilled' => function (\GuzzleHttp\Psr7\Response $response, $index) {
                $this->items[$index]->setResponse($response);
            },
            'rejected' => function (\Exception $reason, $index) {
                $this->errors[$index] = "Request number {$index} failed. Reason {$reason->getMessage()}";
                $this->items[$index]->setError($this->errors[$index]);
            }
        ];
        if ($concurencyLimit) {
            $options['concurrency'] = $concurencyLimit;
        }
        
        $this->createPool($requests, $options)->promise()->wait();
        
        if (!empty($this->errors)) {
            $message = implode(" \n", $this->errors);
            $this->clear();
            
            throw new \RuntimeException($message);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function add(Item $item): PoolInterface
    {
        $this->items[] = $item;

        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $requests
     * @param array $options
     *
     * @return \GuzzleHttp\Pool
     */
    protected function createPool(array $requests, array $options)
    {
        return new \GuzzleHttp\Pool($this->client, $requests, $options);
    }

    /**
     * Clear pool
     */
    protected function clear(): void
    {
        $this->errors = [];
        $this->items = [];
    }
}
