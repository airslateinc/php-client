<?php

namespace AirSlate\ApiClient\Http;

use GuzzleHttp\RequestOptions;

/**
 * Class Client
 * @package AirSlate\ApiClient\Http
 */
class Client extends \GuzzleHttp\Client
{
    /**
     * @var string
     */
    private $include;

    /**
     * @inheritdoc
     */
    public function request($method, $uri = '', array $options = [])
    {
        return parent::request($method, $uri, $this->resolveOptions($options));
    }

    /**
     * @param string|array $include
     * @return Client
     * @throws \Exception
     */
    public function with($include): Client
    {
        if (\is_array($include)) {
            $include = implode(',', $include);
        }

        if (!\is_string($include)) {
            throw new \InvalidArgumentException('Attribute must be a string value.');
        }

        $this->include = $include;

        return $this;
    }

    /**
     * @param array $options
     * @return array
     */
    private function resolveOptions(array $options): array
    {
        if (null !== $this->include) {
            $options[RequestOptions::QUERY]['include'] = $this->include;
        }

        return $options;
    }
}
