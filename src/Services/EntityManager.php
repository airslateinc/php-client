<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Services\EntityManager\Annotation\Resolver;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EntityManager
 * @package AirSlate\ApiClient\Services
 */
class EntityManager
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var Resolver
     */
    protected $annotationResolver;

    /**
     * EntityManager constructor.
     * @param Client $client
     * @param Serializer $serializer
     * @param Resolver $annotationResolver
     */
    public function __construct(
        Client $client,
        Serializer $serializer,
        Resolver $annotationResolver
    )
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->annotationResolver = $annotationResolver;
    }

    /**
     * @param string $entityType
     * @param array $uriParams
     * @param array $queryParams
     * @return EntityManager|object
     */
    public function get(string $entityType, array $uriParams = [], array $queryParams = [])
    {
        return $this->sendAndDeserialize(
            $this->getRequestClosure($entityType, $uriParams, $queryParams),
            $entityType
        );
    }

    /**
     * @param $entityType
     * @param array $uriParams
     * @param array $queryParams
     * @return \Closure
     */
    protected function getRequestClosure($entityType, $uriParams = array(), $queryParams = array())
    {
        $options['query'] = $queryParams;

        return function () use ($entityType, $uriParams, $options) {
            return $this->client->requestAsync(
                Request::METHOD_GET, $this->annotationResolver->getEndpoint($entityType, $uriParams), $options
            );
        };
    }

    /**
     * @param callable $requestClosure
     * @param $type
     * @return array|\JMS\Serializer\scalar|mixed|object
     */
    protected function sendAndDeserialize(\Closure $requestClosure, $type)
    {
        /** @var ResponseInterface $response */
        $response = $requestClosure()->wait();

        return $this->deserialize($response, $type);
    }

    /**
     * @param ResponseInterface $response
     * @param $type
     * @return array|\JMS\Serializer\scalar|mixed|object
     */
    protected function deserialize(ResponseInterface $response, $type)
    {
        return $this->serializer->deserialize($response->getBody()->getContents() ?: '[]', $type, 'json');
    }
}
