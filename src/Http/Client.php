<?php

namespace AirSlate\ApiClient\Http;

use AirSlate\ApiClient\Exceptions\DomainException;
use GuzzleHttp\Exception\RequestException;
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
     * @var array
     */
    private $filter;

    /**
     * @inheritdoc
     * @throws \AirSlate\ApiClient\Exceptions\DomainException
     */
    public function request($method, $uri = '', array $options = [])
    {
        try {
            $response = parent::request($method, $uri, $this->resolveOptions($options));
        } catch (RequestException $exception) {
            $code = $exception->getCode();
            if ($exception->hasResponse()) {
                $code = $exception->getResponse()->getStatusCode();
            }
            throw new DomainException($exception->getMessage(), $code);
        } catch (\Exception $exception) {
            throw new DomainException($exception->getMessage());
        }

        return $response;
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
            throw new \InvalidArgumentException('"$include" must be a string or array value.');
        }

        $this->include = $include;

        return $this;
    }

    /**
     * @param string $key
     * @param array|string $values
     * @return Client
     */
    public function addFilter(string $key, $values): Client
    {
        if (\is_array($values)) {
            $values = implode(',', $values);
        }

        if (!empty($this->filter[$key])) {
            $this->filter[$key] .= ',' . $values;
        } else {
            $this->filter[$key] = $values;
        }

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
        if (null !== $this->filter) {
            $options[RequestOptions::QUERY]['filter'] = $this->filter;
        }

        return $options;
    }
}
