<?php

declare(strict_types=1);

namespace AirSlate\ApiClientTests\Unit\Http;

use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Http\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ClientTest extends TestCase
{
    /**
     * @dataProvider providerErrorResponses
     */
    public function testShouldThrowDomainExceptionOnSyncRequestError(ResponseInterface $errorResponse)
    {
        $this->expectException(DomainException::class);

        $this->getClient([$errorResponse])
            ->request('GET', 'fake.fake');
    }

    /**
     * @dataProvider providerErrorResponses
     */
    public function testShouldThrowDomainExceptionOnAsyncRequestError(ResponseInterface $errorResponse)
    {
        $this->expectException(DomainException::class);

        $this->getClient([$errorResponse])
            ->requestAsync('GET', 'fake.fake')
            ->wait();
    }

    public function providerErrorResponses(): array
    {
        return [
            [new Response(402)],
            [new Response(429)],
            [new Response(503)],
            [new Response(504)],
        ];
    }

    private function getClient(array $responses): Client
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);

        return new Client([
            'handler' => $handlerStack,
        ]);
    }
}
