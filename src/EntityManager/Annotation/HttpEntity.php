<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\EntityManager\Annotation;

/**
 * Class HttpEntity
 * @package AirSlate\ApiClient\EntityManager\Annotation
 *
 * @Annotation
 */
class HttpEntity
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $idProperty = 'id';

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (isset($options['value'])) {
            $options['uri'] = $options['value'];
            unset($options['value']);
        }

        foreach ($options as $key => $value) {
            if (!property_exists($this, $key)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }

            $this->$key = $value;
        }
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getIdProperty(): string
    {
        return $this->idProperty;
    }

    /**
     * @return bool|array
     */
    public function getUriParams()
    {
        if (preg_match_all('/\{(.*)\}/U', $this->getUri(), $matches)) {
            return $matches[1];
        }

        return false;
    }
}
