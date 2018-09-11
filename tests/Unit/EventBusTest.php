<?php

namespace AirSlate\ApiClient\Unit;

use AirSlate\ApiClient\Entities\EventBus\Event;
use AirSlate\ApiClient\Http\Client;
use AirSlate\ApiClient\Services\EventBusService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class EventBusTest extends TestCase
{
    private function createServiceMockFromFixture(string $fixtureName, int $status = 200): EventBusService
    {
        // create response mock handler
        $fixtureName = file_get_contents(__DIR__ . "/fixtures/event_bus/{$fixtureName}.json");
        $mock = new MockHandler([
            new Response($status, [], $fixtureName),
        ]);

        // mock event bus service
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $service = new EventBusService($client);

        return $service;
    }

    public function testGetAccessToken()
    {
        $service = $this->createServiceMockFromFixture('access_token');

        // go and get some token
        $method = new ReflectionMethod(EventBusService::class, 'getAccessToken');
        $method->setAccessible(true);
        $token = $method->invokeArgs($service, ['clientId', 'clientSecret']);

        // assert
        $this->assertEquals('just-a-token-mock', $token->getAccessToken());
    }

    public function testGetWebHook()
    {
        $service = $this->createServiceMockFromFixture('webhook_get');
        $webhook = $service->getWebhook('webhookId');

        $this->assertEquals('B9679100-0000-0000-0000C10F', $webhook->id);
        $this->assertEquals('test', $webhook->routing_key);
        $this->assertEquals('https://webhook.site', $webhook->callback_url);
    }

    public function testPushEvent()
    {
        $source = new Event();
        $source->setAttributes([
            'routing_key' => 'test',
            'payload' => [
                'nested' => [
                    'level' => 2
                ]
            ]
        ]);

        $service = $this->createServiceMockFromFixture('event_push');
        $event = $service->pushEvent($source);

        // assert
        $this->assertEquals('a73185e87615fe065d5289ded510fd22', $event->id);
        $this->assertEquals($source->routing_key, $event->routing_key);
        $this->assertEquals($source->payload, $event->payload);
    }
}
