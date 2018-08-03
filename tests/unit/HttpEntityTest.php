<?php
declare(strict_types=1);

namespace Tests\Unit;

use AirSlate\ApiClient\EntityManager\Annotation\HttpEntity;
use PHPUnit\Framework\TestCase;

/**
 * Class HttpEntityTest
 *
 * @package Tests\Unit
 *
 * @coversDefaultClass \AirSlate\ApiClient\EntityManager\Annotation\HttpEntity
 */
class HttpEntityTest extends TestCase
{
    /**
     * @dataProvider providerOptions
     *
     * @covers ::__construct
     * @covers ::getUri
     * @covers ::getUriParams
     * @covers ::getIdProperty
     *
     * @param array $options
     * @param string $expectedUri
     * @param string $expectedIdProperty
     * @param array $expectedParams
     */
    public function testHttpEntity(
        array $options,
        string $expectedUri,
        string $expectedIdProperty,
        array $expectedParams
    )
    {
        $annotationObject = new HttpEntity($options);
        
        $this->assertEquals($expectedUri, $annotationObject->getUri());
        $this->assertEquals($expectedIdProperty, $annotationObject->getIdProperty());
        
        if ($annotationObject->getUriParams()) {
            $this->assertEmpty(array_diff($expectedParams, $annotationObject->getUriParams()));
        }
    }
    
    /**
     * @covers ::__construct
     */
    public function testHttpEntityException()
    {
        $this->expectException('InvalidArgumentException');
        new HttpEntity(['testParam' => 'testValue']);
    }
    
    public function providerOptions()
    {
        return [
            [['value' => 'users/test'], 'users/test', 'id', []],
            [['value' => 'users/{param}'], 'users/{param}', 'id', ['param']],
            [['value' => 'users/{param}', 'idProperty' => 'test'], 'users/{param}', 'test', ['param']],
            [['value' => 'users/{param}/org/{id}'], 'users/{param}/org/{id}', 'id', ['param', 'id']],
        ];
    }
}
