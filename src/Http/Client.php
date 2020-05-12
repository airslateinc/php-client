<?php

namespace AirSlate\ApiClient\Http;

use AirSlate\ApiClient\Exceptions\DomainException;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;

/**
 * Class Client
 * @package AirSlate\ApiClient\Http
 */
class Client extends \GuzzleHttp\Client
{
    /**
     * @var string|null
     */
    private $include;
    /**
     * @var array|null
     */
    private $filter;
    /**
     * @var array|null
     */
    private $queryParams;
    /**
     * @var string|null
     */
    private $bearerToken;

    /**
     * @var string|null
     */
    private $clientId = '';

    /**
     * @var string|null
     */
    private $clientSecret = '';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->configure($config);

        parent::__construct($config);
    }

    /**
     * @param array $config
     */
    private function configure(array $config): void
    {
        $this->clientId = $config['client_id'] ?? null;
        $this->clientSecret = $config['client_secret'] ?? null;
    }

    /**
     * @inheritdoc
     * @throws DomainException
     */
    public function request($method, $uri = '', array $options = [])
    {
        try {
            $response = parent::request($method, $uri, $options);
        } catch (RequestException $exception) {
            $code = $exception->getCode();
            if ($exception->hasResponse()) {
                $code = $exception->getResponse()->getStatusCode();
            }
            throw new DomainException($exception->getMessage(), $code, $exception);
        } catch (Exception $exception) {
            throw new DomainException($exception->getMessage(), 0, $exception);
        }

        return $response;
    }

    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function requestAsync($method, $uri = '', array $options = [])
    {
        $resolvedOptions = $this->resolveOptions($options);

        $this->clearOptions();

        return parent::requestAsync($method, $uri, $resolvedOptions);
    }

    /**
     * @param string|array $include
     * @return Client
     * @throws Exception
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
     * @param string $key
     * @param $values
     * @return Client
     */
    public function addQueryParam(string $key, $values): Client
    {
        if (\is_array($values)) {
            $values = implode(',', $values);
        }
        $this->queryParams[$key] = $values;

        return $this;
    }

    /**
     * @param string $token
     * @return Client
     */
    public function authToken(string $token): Client
    {
        $this->bearerToken = $token;

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
        if (null !== $this->queryParams) {
            foreach ($this->queryParams as $param => $value) {
                $options[RequestOptions::QUERY][$param] = $value;
            }
        }
        if (null !== $this->bearerToken) {
            $options[RequestOptions::HEADERS]['Authorization'] = "Bearer {$this->bearerToken}";
        }

        return $options;
    }

    /**
     * @return void
     */
    private function clearOptions(): void
    {
        $this->include = null;
        $this->filter = null;
        $this->queryParams = null;
        $this->bearerToken = null;
    }

    /**
     * Get Client ID.
     *
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * Get Client Secret.
     *
     * @return string|null
     */
    public function getClientSecret(): ?string
    {
        return $this->clientSecret;
    }
}
