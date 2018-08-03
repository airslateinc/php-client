<?php
declare(strict_types=1);

namespace Tests\Unit;

use AirSlate\ApiClient\Entity;
use AirSlate\ApiClient\EntityManager\Annotation\HttpEntity;
use AirSlate\ApiClient\EntityManager\Annotation\Resolver;
use AirSlate\ApiClient\EntityManager\Annotation\ResponseType;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\DocParser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class AnnotationResolverTest
 *
 * @package Tests\Unit
 *
 * @coversDefaultClass \AirSlate\ApiClient\EntityManager\Annotation\Resolver
 * @covers ::<protected>
 * @covers ::__construct
 */
class ResolverTest extends TestCase
{
    /**
     * @var Resolver|MockObject
     */
    private $annotationResolver;
    
    /**
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function setUp()
    {
        $this->annotationResolver = new Resolver(new AnnotationReader(new DocParser()));
    }
    
    /**
     * @dataProvider providerEndpoint
     * @covers ::getEndpoint
     *
     * @param string $class
     * @param array $params
     * @param string $expected
     */
    public function testGetEndpoint($class, $params, $expected)
    {
        try {
            $this->assertEquals($expected, $this->annotationResolver->getEndpoint($class, $params));
        } catch (\ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    /**
     * @dataProvider providerIdProperty
     * @covers ::getIdProperty
     *
     * @param $class
     * @param $expected
     */
    public function testGetIdProperty($class, $expected)
    {
        try {
            $this->assertEquals($expected, $this->annotationResolver->getIdProperty($class));
        } catch (\ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    /**
     * @dataProvider providerResponseType
     * @covers ::getResponseType
     *
     * @param string $class
     * @param string $expected
     * @param bool   $isValid
     */
    public function testGetResponseType($class, $expected, $isValid)
    {
        try {
            $type = $class;
            if ($responseType = $this->annotationResolver->getResponseType($class)) {
                $type = $responseType;
            }
            $this->assertEquals($isValid, $expected == $type);
        } catch (\ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    /**
     * @return array
     */
    public function providerEndpoint()
    {
        return [
            [Entity\Slate::class, ['id' => 1], 'slates/1'],
            [Entity\Invite::class, ['orgId' => 1], 'organizations/1/users/invite'],
            [Entity\User::class, ['orgId' => 1, 'id' => 2], 'organizations/1/users/2'],
        ];
    }
    
    /**
     * @return array
     */
    public function providerIdProperty()
    {
        return [
            [Entity\Slate::class, 'id'],
            [Entity\Invite::class, 'id'],
        ];
    }
    
    /**
     * @return array
     */
    public function providerResponseType()
    {
        return [
            [Entity\Slate::class, Entity\Slate::class, true],
            [Entity\User::class, Entity\Slate::class, false],
            [Entity\Invite::class, Entity\User\UserCollection::class, true],
        ];
    }
    
    /**
     *
     */
    public function tearDown()
    {
        unset($this->annotationResolver);
    }
}
