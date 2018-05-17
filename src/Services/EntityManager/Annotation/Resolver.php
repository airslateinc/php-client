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
     * @var array
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
    public function getEndpoint(string $entityType, array $uriParams = []): string
    {
        $annotation = $this->getAnnotation($entityType, HttpEntity::class);

        return trim($this->replaceUriParams($annotation->getUri(), $uriParams), '/');
    }

    /**
     * @param string $entityType
     *
     * @return string
     */
    public function getIdProperty(string $entityType): string
    {
        $annotation = $this->getAnnotation($entityType, HttpEntity::class);

        return $annotation->getIdProperty();
    }

    /**
     * @param string $entityType
     * @return string|null
     * @throws \ReflectionException
     */
    public function getResponseType(string $entityType): ?string
    {
        $annotation = $this->getAnnotation($entityType, ResponseType::class);
        if ($annotation) {
            return $annotation->getType();
        }

        return null;
    }

    /**
     * @param string $type
     * @return HttpEntity|ResponseType
     * @throws \ReflectionException
     */
    protected function getAnnotation(string $type, string $annotationType)
    {
        if (isset($this->annotations[$annotationType]) === false) {
            $this->annotations[$annotationType] = [];
        }

        if (isset($this->annotations[$annotationType][$type]) === false) {
            $class = new \ReflectionClass($type);
            $this->annotations[$annotationType][$type] = $this->annotationReader->getClassAnnotation(
                $class,
                $annotationType
            );
        }

        return $this->annotations[$annotationType][$type];
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
