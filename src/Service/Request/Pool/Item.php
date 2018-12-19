<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Service\Request\Pool;
use GuzzleHttp\Psr7\Response;

/**
 * Class Item
 *
 * @package AirSlate\ApiClient\Services\Request\Pool
 */
class Item
{
    /**
     * @var \Closure
     */
    protected $closure;

    /**
     * @var string
     */
    protected $serrializationType;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $error;

    /**
     * @return \Closure
     */
    public function getClosure(): \Closure
    {
        return $this->closure;
    }

    /**
     * @param \Closure $closure
     *
     * @return Item
     */
    public function setClosure(\Closure $closure): self
    {
        $this->closure = $closure;

        return $this;
    }

    /**
     * @return string
     */
    public function getSerrializationType(): string
    {
        return $this->serrializationType;
    }

    /**
     * @param string $serrializationType
     *
     * @return Item
     */
    public function setSerrializationType(string $serrializationType): self
    {
        $this->serrializationType = $serrializationType;

        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     *
     * @return Item
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     *
     * @return Item
     */
    public function setError(string $error): self
    {
        $this->error = $error;

        return $this;
    }
}
