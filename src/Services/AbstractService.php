<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use Generator;
use AirSlate\ApiClient\Http\Client;
use AirSlate\ApiClient\Entities\BaseEntity;

/**
 * Class UsersService
 * @package AirSlate\ApiClient\Services
 * @method collectionIterator(): Generator
 */
abstract class AbstractService
{
    public const API_VERSION = 'v1';

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiVersion;

    /**
     * UsersService constructor.
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->apiVersion = static::API_VERSION;
    }

    /**
     * @param Client $client
     * @return $this
     */
    public function setClient(Client $client)
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * @param $path
     * @return string
     */
    protected function resolveEndpoint($path): string
    {
        return $this->apiVersion . '/' . ltrim($path, '/');
    }

    /**
     * @param string|array $include
     * @return static
     * @throws \Exception
     */
    public function with($include)
    {
        $this->httpClient->with($include);

        return $this;
    }

    /**
     * @param string $key
     * @param string| array $values
     * @return static
     */
    public function addFilter(string $key, $values)
    {
        $this->httpClient->addFilter($key, $values);

        return $this;
    }

    /**
     * @param string $key
     * @param $values
     * @return $this
     */
    public function addQueryParam(string $key, $values)
    {
        $this->httpClient->addQueryParam($key, $values);

        return $this;
    }

    /**
     * @param $name
     * @param $params
     * @return Generator
     */
    public function __call($name, $params): Generator
    {
        $methodName = str_replace('Iterator', '', $name);
        $page = 1;

        do {
            $objectList = $this->addQueryParam('page', $page)->$methodName();
            $page++;

            /** @var BaseEntity $entity */
            $entity = $objectList[0] ?? null;
            yield $objectList;
        } while ($this->checkPagination($entity));
    }

    /**
     * @param BaseEntity $entity
     * @return bool
     */
    private function checkPagination(?BaseEntity $entity): bool
    {
        if ($entity === null || $entity->getObjectMeta() === []) {
            return false;
        }

        return ($entity->getObjectMeta()['to'] < $entity->getObjectMeta()['total']);
    }
}
