<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services\EntityManager\Annotation;

use Doctrine\Common\Annotations\Reader;

/**
 * Class Resolver
 * @package AirSlate\ApiClient\Services\EntityManager\Annotation
 */
class Resolver
{
    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var array HttpEntity[]
     */
    protected $annotations = [];

    /**
     * Resolver constructor.
     * @param Reader $annotationReader
     */
    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param string $entityType
     * @param array  $uriParams
     * @param bool   $verifyIdProperty
     *
     * @return string
     */
    public function getEndpoint($entityType, array $uriParams = [], $verifyIdProperty = true)
    {
        $annotation = $this->getAnnotation($entityType);
        $uri = $this->replaceUriParams($annotation->getUri(), $uriParams);

        // add id param if entity requires ID
        if ($verifyIdProperty && $annotation->getIdProperty()) {
            if (isset($uriParams['id'])) {
                $uri .= '/' . $uriParams['id'];
            } else {
                throw new \Exception(
                    sprintf('Entity %s requires "id" for uri params', $entityType)
                );
            }
        }

        return $uri;
    }

    /**
     * @param string $type
     * @return HttpEntity
     * @throws \ReflectionException
     */
    protected function getAnnotation(string $type): HttpEntity
    {
        if (isset($this->annotations[$type]) === false) {
            $class = new \ReflectionClass($type);
            $this->annotations[$type] = $this->annotationReader->getClassAnnotation($class, HttpEntity::class);
        }

        return $this->annotations[$type];
    }

    /**
     * Replacing uri params {param1}/{param2} on param1, param2
     *
     * @param string $uri
     * @param array $params
     *
     * @return string
     */
    protected function replaceUriParams($uri, array $params)
    {
        $placeholders = array_map(function ($element) {
            return '{' . $element . '}';
        }, array_keys($params));

        return str_replace($placeholders, $params, $uri);
    }
}
