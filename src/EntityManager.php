<?php
declare(strict_types=1);

namespace AirSlate\ApiClient;

use AirSlate\ApiClient\Contracts\RequestCollectionInterface;
use AirSlate\ApiClient\Entity\Errors;
use AirSlate\ApiClient\EntityManager\Annotation\Resolver;
use AirSlate\ApiClient\EntityManager\Exception\UnprocessableEntityException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\ClientInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class EntityManager
 * @package AirSlate\ApiClient
 */
class EntityManager
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var Resolver
     */
    protected $annotationResolver;

    /**
     * @var string
     */
    protected $errorCollectionType = Errors::class;

    /**
     * @var string
     */
    protected $updateHttpMethod = Request::METHOD_PATCH;
    
    /**
     * @var RequestCollectionInterface
     */
    protected $requestCollection;
    
    /**
     * EntityManager constructor.
     *
     * @param ClientInterface $client
     * @param SerializerInterface $serializer
     * @param Resolver $annotationResolver
     * @param RequestCollectionInterface $requestCollection
     */
    public function __construct(
        ClientInterface $client,
        SerializerInterface $serializer,
        Resolver $annotationResolver,
        RequestCollectionInterface $requestCollection = null
    )
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->annotationResolver = $annotationResolver;
        $this->requestCollection = $requestCollection;
    }
    
    /**
     *
     */
    public function openPool()
    {
        if (!$this->requestCollection) {
            throw new \LogicException('Pool service doesn\'t exists');
        }
    
        $this->requestCollection->open();
    }
    
    /**
     * @return array
     * @throws UnprocessableEntityException
     * @throws \ReflectionException
     */
    public function sendPool()
    {
        if (!$this->requestCollection) {
            throw new \LogicException('Pool service doesn\'t exists');
        }
        
        $this->requestCollection->send($this->client);
        
        $results = [];
        foreach ($this->requestCollection->getResponses() as $index => $response) {
            $results[$index] = $this->deserialize($response, $this->requestCollection->getEntityType($index));
        }
        
        return $results;
    }
    
    /**
     * @param string $entityType
     * @param array $uriParams
     * @param array $queryParams
     * @param array $headerParams
     *
     * @return EntityManager|object
     *
     * @throws UnprocessableEntityException
     * @throws \ReflectionException
     */
    public function get(string $entityType, array $uriParams = [], array $queryParams = [], array $headerParams = [])
    {
        $options = ['query' => $queryParams];
        if ($headerParams) {
            $options['headers'] = $headerParams;
        }

        return $this->sendAndDeserialize(
            $this->getRequestClosure(Request::METHOD_GET, $entityType, $uriParams, $options),
            $entityType
        );
    }
    
    /**
     * @param object $entity
     * @param array $uriParams
     * @param array $queryParams
     * @param array $headerParams
     *
     * @return object
     *
     * @throws UnprocessableEntityException
     * @throws \ReflectionException
     */
    public function create($entity, array $uriParams = [], array $queryParams = [], array $headerParams = [])
    {
        $options = ['query' => $queryParams];
        if (is_object($entity)) {
            if ($this->getIdValue($entity) !== false) {
                $uriParams[$this->getIdPropertyName($entity)] = '';
            }

            $entityType = $this->getEntityType($entity);
            $options = array_merge($options, $this->getRequestOptions($entity));
            if ($headerParams) {
                $options['headers'] = $headerParams;
            }

            return $this->sendAndDeserialize(
                $this->getRequestClosure(Request::METHOD_POST, $entityType, $uriParams, $options),
                $entityType
            );
        } else {
            throw new \InvalidArgumentException('Parameter 1 passed to "create" method must be object');
        }
    }
    
    /**
     * @param object $entity
     * @param array $uriParams
     * @param array $queryParams
     * @param array $headerParams
     *
     * @return object
     *
     * @throws UnprocessableEntityException
     * @throws \ReflectionException
     */
    public function update($entity, $uriParams = [], $queryParams = [], array $headerParams = [])
    {
        $options = ['query' => $queryParams];
        if (is_object($entity)) {
            if ($id = $this->getIdValue($entity)) {
                $uriParams[$this->getIdPropertyName($entity)] = $id;
            }

            $entityType = $this->getEntityType($entity);
            $options = array_merge($options, $this->getRequestOptions($entity));
            if ($headerParams) {
                $options['headers'] = $headerParams;
            }

            return $this->sendAndDeserialize(
                $this->getRequestClosure($this->updateHttpMethod, $entityType, $uriParams, $options),
                $entityType
            );
        } else {
            throw new \InvalidArgumentException('Parameter 1 passed to "update" method is not an object');
        }
    }
    
    /**
     * @param object $entity
     * @param array $uriParams
     * @param array $queryParams
     * @param array $headerParams
     *
     * @return object
     *
     * @throws UnprocessableEntityException
     * @throws \ReflectionException
     */
    public function delete($entity, $uriParams = array(), $queryParams = array(), array $headerParams = [])
    {
        $options = ['query' => $queryParams];
        if (is_object($entity)) {
            if ($id = $this->getIdValue($entity)) {
                $uriParams[$this->getIdPropertyName($entity)] = $id;
            }

            if ($headerParams) {
                $options['headers'] = $headerParams;
            }
            $entityType = $this->getEntityType($entity);

            return $this->sendAndDeserialize(
                $this->getRequestClosure(Request::METHOD_DELETE, $entityType, $uriParams, $options),
                $entityType
            );
        } else {
            throw new \InvalidArgumentException('Parameter 1 passed to "delete" method is not an object');
        }
    }

    /**
     * @param string $updateHttpMethod
     * @return $this
     */
    public function setUpdateHttpMethod(string $updateHttpMethod)
    {
        $this->updateHttpMethod = $updateHttpMethod;

        return $this;
    }

    /**
     * @param string $method
     * @param string $entityType
     * @param array $uriParams
     * @param array $options
     * @return \Closure
     */
    protected function getRequestClosure(string $method, string $entityType, array $uriParams, array $options): \Closure
    {
        return function () use ($method, $entityType, $uriParams, $options) {
            return $this->client->requestAsync(
                $method,
                $this->annotationResolver->getEndpoint($entityType, $uriParams),
                $options
            );
        };
    }

    /**
     * @param object $entity
     * @return array
     */
    protected function getRequestOptions($entity)
    {
        return [
            'body' => $this->serializer->serialize(
                $entity, 'json', SerializationContext::create()->setGroups(['Default'])
            ),
        ];
    }
    
    /**
     * @param \Closure $requestClosure
     * @param $type
     *
     * @return mixed
     * @throws UnprocessableEntityException
     * @throws \ReflectionException
     */
    protected function sendAndDeserialize(\Closure $requestClosure, $type)
    {
        if (!($this->requestCollection && $this->requestCollection->isOpen())) {
            /** @var ResponseInterface $response */
            $response = $requestClosure()->wait();
            
            return $this->deserialize($response, $type);
        }
    
        $this->requestCollection->addRequest($requestClosure, $type);
    }
    
    /**
     * @param ResponseInterface $response
     * @param $type
     *
     * @return object
     *
     * @throws UnprocessableEntityException
     * @throws \ReflectionException
     */
    protected function deserialize(ResponseInterface $response, $type)
    {
        /**
         * @todo: think about moving it to other service which will be responsible for exceptions
         * Current implementation only as example how we could store errors response
         */
        if ($response->getStatusCode() === Response::HTTP_UNPROCESSABLE_ENTITY) {
            $response = $this->serializer
                ->deserialize($response->getBody()->getContents() ?: '[]', $this->errorCollectionType, 'json');

            throw new UnprocessableEntityException('You are missing required data during saving process');
        }

        if ($responseType = $this->annotationResolver->getResponseType($type)) {
            $type = $responseType;
        }

        return $this->serializer->deserialize($response->getBody()->getContents() ?: '[]', $type, 'json');
    }

    /**
     * @param mixed $entity
     *
     * @return string
     */
    protected function getEntityType($entity)
    {
        if (is_object($entity)) {
            $entity = get_class($entity);
        }

        return trim($entity, '\\');
    }
    
    /**
     * @param object $entity
     *
     * @return bool|string
     * @throws \ReflectionException
     */
    protected function getIdValue($entity)
    {
        $idProperty = $this->getIdPropertyName($entity);
        if ($idProperty) {
            $entityIdGetter = 'get' . ucfirst($idProperty);
            if (method_exists($entity, $entityIdGetter)) {
                return $entity->$entityIdGetter();
            } else {
                throw new \BadMethodCallException('Id getter does not exist');
            }
        }

        return false;
    }
    
    /**
     * @param object|string $entity
     *
     * @return string
     * @throws \ReflectionException
     */
    protected function getIdPropertyName($entity): string
    {
        if (is_object($entity)) {
            $entity = $this->getEntityType($entity);
        }

        return $this->annotationResolver->getIdProperty($entity);
    }
}
