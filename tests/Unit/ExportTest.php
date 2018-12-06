<?php

namespace AirSlate\ApiClient\Unit;

use AirSlate\ApiClient\Http\Client;
use AirSlate\ApiClient\Models\Export\Create;
use AirSlate\ApiClient\Services\ExportService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ExportTest extends TestCase
{
    public function testModelCreate()
    {
        $docId = "F67D2000-0000-0000-000021F6";
        $exportDto = (new Create())->addDocument($docId);
        $array = $exportDto->toArray();
        $this->assertEquals($docId, $array['data']['relationships']['documents'][0]['data']['id']);
    }

    public function testServiceCreate()
    {
        $fixture = file_get_contents(__DIR__ . '/fixtures/export/export_created.json');
        $mock = new MockHandler([
            new Response(200, [], $fixture),
        ]);
        $handler = HandlerStack::create($mock);

        $container = [];
        $history = Middleware::history($container);
        $handler->push($history);

        $client = new Client(['handler' => $handler]);

        $exportClient = new ExportService($client);

        $exportDto = (new Create())->addDocument("F67D2000-0000-0000-000021F6");
        $result = $exportClient->create($exportDto);

        /** @var Request $request */
        $request = $container[0]['request'];
        /** @var Response $response */
        $response = $container[0]['response'];

        $this->assertEquals('v1/export', $request->getUri()->getPath());

        $fixtureDecoded = json_decode($fixture, true);
        $this->assertEquals($fixtureDecoded, $result);
    }
}
