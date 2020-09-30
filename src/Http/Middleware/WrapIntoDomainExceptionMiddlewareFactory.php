<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Http\Middleware;

use AirSlate\ApiClient\Exceptions\DomainException;
use GuzzleHttp\Exception\RequestException;
use Throwable;

class WrapIntoDomainExceptionMiddlewareFactory
{
    public function make(): callable
    {
        return function (callable $handler) {
            return function ($request, array $options) use ($handler) {
                return $handler($request, $options)->then(null, $this->getExceptionHandler());
            };
        };
    }

    /**
     * Wrap all exceptions into DomainException
     *
     * @return callable
     */
    private function getExceptionHandler(): callable
    {
        return function ($exception) {
            if ($exception instanceof RequestException) {
                $code = $exception->getCode();

                if ($exception->hasResponse()) {
                    $code = $exception->getResponse()->getStatusCode();
                }

                throw new DomainException($exception->getMessage(), $code, $exception);
            }

            if ($exception instanceof Throwable) {
                throw new DomainException($exception->getMessage(), 0, $exception);
            }

            return $exception;
        };
    }
}
