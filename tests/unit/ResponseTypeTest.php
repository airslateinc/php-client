<?php
declare(strict_types=1);

namespace Tests\Unit;

use AirSlate\ApiClient\EntityManager\Annotation\ResponseType;
use PHPUnit\Framework\TestCase;

/**
 * Class ResponseTypeTest
 *
 * @package Tests\Unit
 *
 * @coversDefaultClass \AirSlate\ApiClient\EntityManager\Annotation\ResponseType
 */
class ResponseTypeTest extends TestCase
{
    /**
     * @dataProvider providerOptions
     *
     * @covers ::__construct
     * @covers ::getType
     *
     * @param array $options
     * @param string $expectedType
     */
    public function testResponseType(array $options, string $expectedType)
    {
        $annotationObject = new ResponseType($options);
        $this->assertEquals($expectedType, $annotationObject->getType());
    }
    
    /**
     * @covers ::__construct
     */
    public function testResponseTypeException()
    {
        $this->expectException('InvalidArgumentException');
        new ResponseType(['invalidKey' => 'value']);
    }
    
    /**
     * @return array
     */
    public function providerOptions()
    {
        return [
            [['value' => 'type'], 'type'],
            [['value' => 'another type'], 'another type'],
        ];
    }
}
