<?php
declare(strict_types=1);

namespace Tests\Unit;

use AirSlate\ApiClient\Entity;
use AirSlate\ApiClient\EntityManager;
use AirSlate\ApiClient\EntityManager\Annotation\Resolver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\DocParser;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EntityManagerTest
 *
 * @package Tests\Unit
 * @coversDefaultClass \AirSlate\ApiClient\EntityManager
 * @covers ::__construct
 * @uses \AirSlate\ApiClient\EntityManager\Annotation\Resolver
 * @uses \AirSlate\ApiClient\EntityManager\Annotation\HttpEntity
 */
class EntityManagerTest extends TestCase
{
    /**
     * @var Serializer
     */
    private $serializer;
    
    /**
     * @var MockObject|Client
     */
    private $clientMock;
    
    /**
     * @var Resolver
     */
    private $resolver;
    
    /**
     * @var MockObject
     */
    private $response;
    
    /**
     * @var MockObject
     */
    private $promise;
    
    /**
     * @var MockObject|StreamInterface
     */
    private $stream;
    
    /**
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     * @throws \ReflectionException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function setUp()
    {
        $this->response = $this->getMockForAbstractClass(ResponseInterface::class);
        $this->promise = $this->getMockForAbstractClass(Promise\PromiseInterface::class);
        $this->stream = $this->getMockForAbstractClass(StreamInterface::class);
    
        $this->clientMock = $this->getMockBuilder(Client::class)
            ->setMethods(['requestAsync'])
            ->getMock();
        
        $this->serializer = SerializerBuilder::create()->build();
        $this->resolver = new Resolver(new AnnotationReader(new DocParser()));
        
        $this->entityManager = new EntityManager($this->clientMock, $this->serializer, $this->resolver);
    }
    
    /**
     * @dataProvider providerGet
     *
     * @covers ::get
     * @covers ::sendAndDeserialize
     * @uses \AirSlate\ApiClient\EntityManager::deserialize
     * @uses \AirSlate\ApiClient\EntityManager::getRequestClosure
     *
     * @param string $class
     * @param string $content
     * @param string $expected
     * @param array $params
     */
    public function testGet($class, $content, $expected, $params)
    {
        $this->response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);
        
        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn($content);

        $this->promise
            ->expects($this->once())
            ->method('wait')
            ->willReturn($this->response);

        $this->clientMock
            ->expects($this->once())
            ->method('requestAsync')
            ->willReturn($this->promise);
    
        try {
            $result = $this->entityManager->get(
                $class,
                $params['uriParams'],
                $params['queryParams'],
                $params['headerParams']
            );
            
            $this->assertEquals($expected, $result->getData()->getId());
        } catch (\ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    /**
     * @dataProvider providerCreate
     *
     * @covers ::create
     * @covers ::sendAndDeserialize
     * @uses \AirSlate\ApiClient\EntityManager::deserialize
     * @uses \AirSlate\ApiClient\EntityManager::getRequestClosure
     * @uses \AirSlate\ApiClient\EntityManager::getEntityType
     * @uses \AirSlate\ApiClient\EntityManager::getIdPropertyName
     * @uses \AirSlate\ApiClient\EntityManager::getIdValue
     * @uses \AirSlate\ApiClient\EntityManager::getRequestOptions
     *
     * @param object $entity
     * @param string $content
     * @param string $expected
     * @param array $params
     */
    public function testCreate($entity, $content, $expected, $params)
    {
        $this->response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);
    
        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn($content);

        $this->promise
            ->expects($this->once())
            ->method('wait')
            ->willReturn($this->response);

        $this->clientMock
            ->expects($this->once())
            ->method('requestAsync')
            ->willReturn($this->promise);
        
        try {
            $this->assertEmpty($entity->getData()->getId());
            
            $result = $this->entityManager->create(
                $entity,
                $params['uriParams'],
                $params['queryParams'],
                $params['headerParams']
            );
            
            $this->assertEquals($expected, $result->getData()->getId());
        } catch (\ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    /**
     * @dataProvider providerUpdate
     *
     * @covers ::update
     * @covers ::sendAndDeserialize
     * @uses \AirSlate\ApiClient\EntityManager::deserialize
     * @uses \AirSlate\ApiClient\EntityManager::getRequestClosure
     * @uses \AirSlate\ApiClient\EntityManager::sendAndDeserialize
     * @uses \AirSlate\ApiClient\EntityManager::getEntityType
     * @uses \AirSlate\ApiClient\EntityManager::getIdPropertyName
     * @uses \AirSlate\ApiClient\EntityManager::getIdValue
     * @uses \AirSlate\ApiClient\EntityManager::getRequestOptions
     *
     * @param object $entity
     * @param string $content
     * @param string $expected
     * @param array $params
     */
    public function testUpdate($entity, string $content, string $expected, array $params)
    {
        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn($content);
    
        $this->response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);
    
        $this->promise
            ->expects($this->once())
            ->method('wait')
            ->willReturn($this->response);
    
        $this->clientMock
            ->expects($this->once())
            ->method('requestAsync')
            ->willReturn($this->promise);
    
        try {
            $this->assertNotEquals($expected, $entity->getData()->getAttributes()->getName());
            
            $result = $this->entityManager->update(
                $entity,
                $params['uriParams'],
                $params['queryParams'],
                $params['headerParams']
            );
            
            $this->assertEquals($expected, $result->getData()->getAttributes()->getName());
        } catch (\ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    /**
     * @covers ::delete
     * @covers ::sendAndDeserialize
     * @uses \AirSlate\ApiClient\EntityManager::deserialize
     * @uses \AirSlate\ApiClient\EntityManager::getRequestClosure
     * @uses \AirSlate\ApiClient\EntityManager::sendAndDeserialize
     * @uses \AirSlate\ApiClient\EntityManager::getEntityType
     * @uses \AirSlate\ApiClient\EntityManager::getIdPropertyName
     * @uses \AirSlate\ApiClient\EntityManager::getIdValue
     */
    public function testDelete()
    {
        $slate = new Entity\Slate();
        $slate->setData(new Entity\Slate\SlateData());
        $slate->getData()->setId('E3D0D900-0000-0000-0000BA29');
    
        $this->response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);
    
        $this->promise
            ->expects($this->once())
            ->method('wait')
            ->willReturn($this->response);
    
        $this->clientMock
            ->expects($this->once())
            ->method('requestAsync')
            ->willReturn($this->promise);
    
        try {
            $this->entityManager->delete($slate, [], [], ['Content-Type' => 'multipart/form-data']);
        } catch (\ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    /**
     * @covers ::getRequestClosure
     * @uses \AirSlate\ApiClient\EntityManager::get
     * @uses \AirSlate\ApiClient\EntityManager::sendAndDeserialize
     *
     * @throws \ReflectionException
     */
    public function testGetRequestClosure()
    {
        $entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->setConstructorArgs([$this->clientMock, $this->serializer, $this->resolver])
            ->setMethods(['sendAndDeserialize'])
            ->getMock();
        
        $this->clientMock
            ->expects($this->once())
            ->method('requestAsync')
            ->willReturn($this->promise);
        
        $entityManagerMock
            ->expects($this->once())
            ->method('sendAndDeserialize')
            ->willReturnCallback(function (\Closure $requestClosure, $type) {
                
                $this->assertTrue(is_callable($requestClosure));
                $this->assertTrue(method_exists($requestClosure(), 'wait'));
                
                return $this->getMockForAbstractClass(Entity\Slate::class);
            });
        
        $entityManagerMock->get(Entity\Slate::class);
    }
    
    /**
     * @dataProvider providerDeserialize
     *
     * @covers ::deserialize
     * @uses         \AirSlate\ApiClient\EntityManager::get
     * @uses         \AirSlate\ApiClient\EntityManager::getRequestClosure
     * @uses         \AirSlate\ApiClient\EntityManager::sendAndDeserialize
     *
     * @param string  $class
     * @param boolean $isException
     *
     * @throws \ReflectionException
     */
    public function testDeserialize(string $class, bool $isException)
    {
        $this->response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($this->getMockForAbstractClass(StreamInterface::class));
    
        $this->promise
            ->expects($this->once())
            ->method('wait')
            ->willReturn($this->response);
    
        $this->clientMock
            ->expects($this->once())
            ->method('requestAsync')
            ->willReturn($this->promise);
        
        if ($isException) {
            $this->response
                ->expects($this->once())
                ->method('getStatusCode')
                ->willReturn(Response::HTTP_UNPROCESSABLE_ENTITY);
            
            $this->expectException('\AirSlate\ApiClient\EntityManager\Exception\UnprocessableEntityException');
            
            $this->entityManager->get($class);
            
        } else {
            $type = $class;
            if ($responseType = $this->resolver->getResponseType($class)) {
                $type = $responseType;
            }
            
            $result = $this->entityManager->get($class);
            $this->assertInstanceOf($type, $result);
        }

        
    }
    
    /**
     * @dataProvider providerExceptionCases
     *
     * @covers ::create
     * @covers ::update
     * @covers ::delete
     *
     * @param string $method
     * @param string $exception
     * @param string $exceptionMessage
     */
    public function testInvalidEntityObj($method, $exception, $exceptionMessage)
    {
        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);
        try {
            switch ($method) {
                case 'create':
                    $this->entityManager->create('Test data');
                    break;
                case 'update':
                    $this->entityManager->update('Test data');
                    break;
                case 'delete':
                    $this->entityManager->delete('Test data');
                    break;
                default:
                    $this->fail('Invalid data in provider');
            }
        } catch (\ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    /**
     * @dataProvider providerRequestConfig
     *
     * @covers ::setUpdateHttpMethod
     * @covers ::getRequestOptions
     * @uses \AirSlate\ApiClient\EntityManager::update
     * @uses \AirSlate\ApiClient\EntityManager::getRequestClosure
     * @uses \AirSlate\ApiClient\EntityManager::getEntityType
     * @uses \AirSlate\ApiClient\EntityManager::getIdPropertyName
     * @uses \AirSlate\ApiClient\EntityManager::getIdValue
     *
     * @param object $entity
     * @param string $requestMethod
     */
    public function testRequestConfig($entity, string $requestMethod)
    {
        $entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->setConstructorArgs([$this->clientMock, $this->serializer, $this->resolver])
            ->setMethods(['sendAndDeserialize'])
            ->getMock();
    
        $this->clientMock
            ->method('requestAsync')
            ->willReturnCallback(function($method, $uri, array $options = []) use ($requestMethod, $entity) {
                $this->assertEquals($requestMethod, $method);
                
                $expectedBody = $this->serializer->serialize(
                    $entity, 'json', SerializationContext::create()->setGroups(['Default'])
                );
                $this->assertEquals($options['body'], $expectedBody);
                
                return $this->promise;
            });
        
        $entityManagerMock
            ->expects($this->once())
            ->method('sendAndDeserialize')
            ->willReturnCallback(function(\Closure $requestClosure, $type) {
                $requestClosure();
            });
        
            $entityManagerMock->setUpdateHttpMethod($requestMethod);
            $entityManagerMock->update($entity);
    }
    
    /**
     * @dataProvider providerEntities
     *
     * @covers ::getEntityType
     * @uses \AirSlate\ApiClient\EntityManager::delete
     *
     * @param $entity
     * @param string $expected
     */
    public function testEntityType($entity, string $expected)
    {
        $entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->setConstructorArgs([$this->clientMock, $this->serializer, $this->resolver])
            ->setMethods(['sendAndDeserialize', 'getRequestClosure', 'getIdValue'])
            ->getMock();
    
        $entityManagerMock
            ->expects($this->once())
            ->method('getIdValue')
            ->willReturn(false);
    
        $entityManagerMock
            ->expects($this->once())
            ->method('getRequestClosure');
    
        $entityManagerMock
            ->expects($this->once())
            ->method('sendAndDeserialize')
            ->willReturnCallback(function ($requestClosure, $type) use ($expected) {
                $this->assertEquals($expected, $type);
                
                return $this->response;
            });
    
        $entityManagerMock->delete($entity);
    }
    
    /**
     * @dataProvider providerIdPropertyData
     *
     * @covers ::getIdPropertyName
     * @covers ::getIdValue
     * @uses \AirSlate\ApiClient\EntityManager::delete
     * @uses \AirSlate\ApiClient\EntityManager::getEntityType
     *
     * @param object $entity
     * @param string $expectedIdProperty
     * @param string|null $expectedIdValue
     */
    public function testIdProperty($entity, string $expectedIdProperty, ?string $expectedIdValue)
    {
        $entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->setConstructorArgs([$this->clientMock, $this->serializer, $this->resolver])
            ->setMethods(['sendAndDeserialize', 'getRequestClosure'])
            ->getMock();
        
        $entityManagerMock
            ->expects($this->once())
            ->method('sendAndDeserialize');
        
        $entityManagerMock
            ->expects($this->once())
            ->method('getRequestClosure')
            ->willReturnCallback(function(
                string $method,
                string $entityType,
                array $uriParams,
                array $options
            ) use ($expectedIdProperty, $expectedIdValue) {
                $this->assertTrue(isset($uriParams[$expectedIdProperty]));
                $this->assertEquals($uriParams[$expectedIdProperty], $expectedIdValue);
                
                return function(){};
            });
        
        $entityManagerMock->delete($entity);
    }
    
    /**
     * @dataProvider providerIdPropertyData
     *
     * @covers ::getIdPropertyName
     * @covers ::getIdValue
     * @uses \AirSlate\ApiClient\EntityManager::delete
     * @uses \AirSlate\ApiClient\EntityManager::getEntityType
     *
     * @param $collection
     */
    public function testIdPropertyForCollection()
    {
        $entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->setConstructorArgs([$this->clientMock, $this->serializer, $this->resolver])
            ->setMethods(['sendAndDeserialize', 'getRequestClosure', 'getIdPropertyName'])
            ->getMock();
        
        $entityManagerMock
            ->expects($this->once())
            ->method('sendAndDeserialize');
        
        $entityManagerMock
            ->method('getIdPropertyName')
            ->willReturn('');
        
        $entityManagerMock
            ->expects($this->once())
            ->method('getRequestClosure')
            ->willReturnCallback(function(
                string $method,
                string $entityType,
                array $uriParams,
                array $options
            ) {
                $this->assertEmpty($uriParams);
                
                return function(){};
            });
        
        $entityManagerMock->delete(new Entity\Slate\SlateCollection());
    }
    
    /**
     * @dataProvider providerIdPropertyData
     *
     * @covers ::getIdValue
     * @uses \AirSlate\ApiClient\EntityManager::delete
     */
    public function testIdPropertyException()
    {
        $entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->setConstructorArgs([$this->clientMock, $this->serializer, $this->resolver])
            ->setMethods(['sendAndDeserialize', 'getIdPropertyName'])
            ->getMock();
        
        $entityManagerMock
            ->method('getIdPropertyName')
            ->willReturn('invalidProperty');
        
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('Id getter does not exist');
        
        $entityManagerMock->delete($this->getMockForAbstractClass(Stub::class));
    }
    
    /**
     * @return array
     */
    public function providerGet()
    {
        return [
            [
                Entity\Slate::class,
                '{"data":{"type":"slates","id":"E3D0D900-0000-0000-0000BA29"}}',
                'E3D0D900-0000-0000-0000BA29',
                [
                    'uriParams' => [],
                    'queryParams' => [],
                    'headerParams' => ['Content-Type' => 'application/json'],
                ]
            ],
            [
                Entity\User::class,
                '{"data":{"type":"users","id":"26C04700-0000-0000-00009BC6"}}',
                '26C04700-0000-0000-00009BC6',
                [
                    'uriParams' => [],
                    'queryParams' => [],
                    'headerParams' => ['Content-Type' => 'application/json'],
                ]
            ],
        ];
    }
    
    /**
     * @return array
     */
    public function providerCreate()
    {
        $slate = new Entity\Slate();
        $slate->setData(new Entity\Slate\SlateData());
        
        $user = new Entity\User();
        $user->setData(new Entity\User\UserData());
        return [
            [
                $slate,
                '{"data":{"type":"slates","id":"E3D0D900-0000-0000-0000BA29"}}',
                'E3D0D900-0000-0000-0000BA29',
                [
                    'uriParams' => [],
                    'queryParams' => [],
                    'headerParams' => ['Content-Type' => 'application/json'],
                ]
            ],
            [
                $user,
                '{"data":{"type":"users","id":"26C04700-0000-0000-00009BC6"}}',
                '26C04700-0000-0000-00009BC6',
                [
                    'uriParams' => [],
                    'queryParams' => [],
                    'headerParams' => ['Content-Type' => 'application/json'],
                ]
            ],
        ];
    }
    
    /**
     * @return array
     */
    public function providerUpdate()
    {
        $slate = new Entity\Slate();
        $slate->setData(new Entity\Slate\SlateData());
        $slate->getData()->setAttributes(new Entity\Slate\SlateAttributes());
        $slate->getData()->setId('E3D0D900-0000-0000-0000BA29');
        $slate->getData()->getAttributes()->setName('Test slate');

        return [
            [
                $slate,
                '{"data":{"type":"slates","id":"E3D0D900-0000-0000-0000BA29", "attributes":{"name": "Slate 1"}}}',
                'Slate 1',
                [
                    'uriParams' => [],
                    'queryParams' => [],
                    'headerParams' => ['Content-Type' => 'application/json'],
                ]
            ],
        ];
    }
    
    /**
     * @return array
     */
    public function providerDeserialize()
    {
        return [
            [Entity\Slate::class, false],
            [Entity\Slate::class, true],
            [Entity\Invite::class, false],
        ];
    }
    
    public function providerExceptionCases()
    {
        return [
            ['create', 'InvalidArgumentException', 'Parameter 1 passed to "create" method must be object'],
            ['update', 'InvalidArgumentException', 'Parameter 1 passed to "update" method is not an object'],
            ['delete', 'InvalidArgumentException', 'Parameter 1 passed to "delete" method is not an object'],
        ];
    }
    
    public function providerRequestConfig()
    {
        $slate = new Entity\Slate();
        $slate->setData(new Entity\Slate\SlateData());
        $slate->getData()->setAttributes(new Entity\Slate\SlateAttributes());
        $slate->getData()->setId('E3D0D900-0000-0000-0000BA29');
        $slate->getData()->getAttributes()->setName('Test slate');
    
        $user = new Entity\User();
        $user->setData(new Entity\User\UserData());
        $user->getData()->setAttributes(new Entity\User\UserAttributes());
        $user->getData()->setId('test id');
        $user->getData()->getAttributes()->setEmail('test@test.com');
        return [
            [$slate, Request::METHOD_PUT],
            [$user, Request::METHOD_POST],
        ];
    }
    
    /**
     * @return array
     */
    public function providerEntities()
    {
        return [
            [new Entity\Slate(), Entity\Slate::class],
            [new Entity\Invite(), Entity\Invite::class],
        ];
    }
    
    public function providerIdPropertyData()
    {
        $slate = new Entity\Slate();
        $slate->setData(new Entity\Slate\SlateData());
        $slate->getData()->setId('E3D0D900-0000-0000-0000BA29');
        
        return [
            [$slate, 'id', 'E3D0D900-0000-0000-0000BA29'],
        ];
    }
    
    /**
     *
     */
    public function tearDown()
    {
        unset($this->resolver, $this->clientMock, $this->promise, $this->response, $this->serializer);
        unset($this->entityManager);
    }
}
