<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services\EntityManager\Annotation;

/**
 * Class ResponseType
 * @package AirSlate\ApiClient\Services\EntityManager
 *
 * @Annotation
 */
class ResponseType
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (isset($options['value'])) {
            $this->type = $options['value'];
        } else {
            throw new \InvalidArgumentException('You must define response type');
        }
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
