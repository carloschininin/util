<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Tests;

use CarlosChininin\Util\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testEndsWith(): void
    {
        $this->assertTrue(Helper::endsWith('test', 'this is a test'));
        $this->assertFalse(Helper::endsWith('test', 'this is a tes'));
        $this->assertTrue(Helper::endsWith('', 'this is a test'));
    }

    public function testDateToString(): void
    {
        $date = new \DateTimeImmutable('2023-01-01 10:00:00', new \DateTimeZone('UTC'));
        $this->assertSame('2023-01-01T10:00:00+00:00', Helper::dateToString($date));
    }

    public function testStringToDate(): void
    {
        $date = Helper::stringToDate('2023-01-01 10:00:00');
        $this->assertInstanceOf(\DateTimeImmutable::class, $date);
        $this->assertSame('2023-01-01 10:00:00', $date->format('Y-m-d H:i:s'));
    }

    public function testJsonEncode(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $this->assertSame('{"a":1,"b":2}', Helper::jsonEncode($data));
    }

    public function testJsonDecode(): void
    {
        $json = '{"a":1,"b":2}';
        $this->assertSame(['a' => 1, 'b' => 2], Helper::jsonDecode($json));
    }

    public function testJsonDecodeWithInvalidJson(): void
    {
        $this->expectException(\RuntimeException::class);
        Helper::jsonDecode('{a:1}');
    }

    public function testToSnakeCase(): void
    {
        $this->assertSame('hello_world', Helper::toSnakeCase('HelloWorld'));
        $this->assertSame('hello_world', Helper::toSnakeCase('helloWorld'));
        $this->assertSame('hello', Helper::toSnakeCase('hello'));
    }

    public function testToCamelCase(): void
    {
        $this->assertSame('helloWorld', Helper::toCamelCase('hello_world'));
        $this->assertSame('helloWorld', Helper::toCamelCase('hello world'));
    }

    public function testDot(): void
    {
        $data = [
            'a' => 1,
            'b' => [
                'c' => 2,
                'd' => ['e' => 3],
            ],
        ];
        $expected = ['a' => 1, 'b.c' => 2, 'b.d.e' => 3];
        $this->assertSame($expected, Helper::dot($data));
    }

    public function testExtractClassName(): void
    {
        $object = new \stdClass();
        $this->assertSame('stdClass', Helper::extractClassName($object));
    }

    public function testIterableToArray(): void
    {
        $iterable = new \ArrayIterator(['a' => 1, 'b' => 2]);
        $this->assertSame(['a' => 1, 'b' => 2], Helper::iterableToArray($iterable));
    }

    public function testDni(): void
    {
        $this->assertSame('00001234', Helper::dni(1234));
        $this->assertSame('12345678', Helper::dni('12345678'));
        $this->assertSame('', Helper::dni(null));
    }

    public function testFecha(): void
    {
        $this->assertInstanceOf(\DateTime::class, Helper::fecha('2023-01-01'));
        $this->assertNull(Helper::fecha('invalid date'));
        $this->assertNull(Helper::fecha(null));
    }

    public function testDecimal(): void
    {
        $this->assertSame(123.45, Helper::decimal('123.45'));
        $this->assertSame(1234.56, Helper::decimal('1,234.56'));
        $this->assertSame(123.0, Helper::decimal(123));
        $this->assertNull(Helper::decimal('abc'));
        $this->assertNull(Helper::decimal(null));
    }

    public function testSerialNumber(): void
    {
        $this->assertSame('000123', Helper::serialNumber(123));
        $this->assertSame('000001', Helper::serialNumber('1', 6));
        $this->assertNull(Helper::serialNumber(null));
    }

    public function testCleanUpperText(): void
    {
        $this->assertSame('HELLOWORLD', Helper::cleanUpperText('Hello, World;'));
        $this->assertSame('TEST', Helper::cleanUpperText(' t.e,s;t '));
        $this->assertNull(Helper::cleanUpperText(null));
    }

    public function testMonths(): void
    {
        $this->assertCount(12, Helper::months());
        $this->assertSame('Enero', Helper::months()[1]);
    }
}
