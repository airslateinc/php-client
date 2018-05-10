<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entity\Errors;
use AirSlate\ApiClient\Services\EntityManager\Annotation\Resolver;
use AirSlate\ApiClient\Services\EntityManager\Exception\UnprocessableEntityException;
use GuzzleHttp\Client;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @var string
     */
    protected $errorCollectionType = Errors::class;

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
        $options['query'] = $queryParams;
        $closure = function () use ($entityType, $uriParams, $options) {
            return $this->client->requestAsync(
                Request::METHOD_GET, $this->annotationResolver->getEndpoint($entityType, $uriParams), $options
            );
        };

        return $this->sendAndDeserialize($closure, $entityType);
    }

    /**
     * @param object $entity
     * @param array $uriParams
     * @param array $queryParams
     * @return array|\JMS\Serializer\scalar|mixed|object
     */
    public function create($entity, array $uriParams = [], array $queryParams = [])
    {
        if (is_object($entity)) {
            $entityType = $this->getEntityType($entity);
            $options = $this->getRequestOptions($entity);

            $closure = function () use ($entityType, $uriParams, $options) {
                return $this->client->requestAsync(
                    Request::METHOD_POST,
                    $this->annotationResolver->getEndpoint($entityType, $uriParams, false),
                    $options
                );
            };

            return $this->sendAndDeserialize($closure, $entityType);
        } else {
            throw new \InvalidArgumentException('Parameter 1 passed to "create" method must be object');
        }
    }

    /**
     * @param object $entity
     * @param array $uriParams
     * @param array $queryParams
     * @return array|\JMS\Serializer\scalar|mixed|object
     */
    public function update($entity, $uriParams = [], $queryParams = [])
    {
        if (is_object($entity)) {
            if ($id = $this->getIdValue($entity)) {
                $uriParams['id'] = $id;
            }

            $entityType = $this->getEntityType($entity);
            $options = $this->getRequestOptions($entity);
            $closure = function () use ($entityType, $uriParams, $options) {
                return $this->client->requestAsync(
                    Request::METHOD_PATCH,
                    $this->annotationResolver->getEndpoint($entityType, $uriParams),
                    $options
                );
            };

            return $this->sendAndDeserialize($closure, $entityType);
        } else {
            throw new \InvalidArgumentException('Parameter 1 passed to "update" method is not an object');
        }
    }

    /**
     * @param object $entity
     * @param array $uriParams
     * @param array $queryParams
     * @return array|\JMS\Serializer\scalar|mixed|object
     */
    public function delete($entity, $uriParams = array(), $queryParams = array())
    {
        if (is_object($entity)) {
            if ($id = $this->getIdValue($entity)) {
                $uriParams['id'] = $id;
            }

            $entityType = $this->getEntityType($entity);
            $closure = function () use ($entityType, $uriParams) {
                return $this->client->requestAsync(
                    Request::METHOD_DELETE,
                    $this->annotationResolver->getEndpoint($entityType, $uriParams)
                );
            };

            return $this->sendAndDeserialize($closure, $entityType);
        } else {
            throw new \InvalidArgumentException('Parameter 1 passed to "delete" method is not an object');
        }
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
        /**
         * @todo: think about moving it to other service which will be responsible for exceptions
         * Current implementation only as example how we could store errors response
         */
        if ($response->getStatusCode() === Response::HTTP_UNPROCESSABLE_ENTITY) {
            $response = $this->serializer
                ->deserialize($response->getBody()->getContents() ?: '[]', $this->errorCollectionType, 'json');

            throw new UnprocessableEntityException('You are missing required data during saving process');
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
     * @return bool|string
     */
    protected function getIdValue($entity)
    {
        $idProperty = $this->annotationResolver->getIdProperty($this->getEntityType($entity));
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
}
