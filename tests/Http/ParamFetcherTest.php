<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Tests\Http;

use CarlosChininin\Util\Http\ParamFetcher;
use CarlosChininin\Util\Validator\InvalidDataValidatorException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ParamFetcherTest extends TestCase
{
    public function testGetRequiredString(): void
    {
        $fetcher = new ParamFetcher(['foo' => 'bar']);
        $this->assertSame('bar', $fetcher->getRequiredString('foo'));
    }

    public function testGetRequiredStringThrowsExceptionWhenKeyDoesNotExist(): void
    {
        $this->expectException(InvalidDataValidatorException::class);
        $fetcher = new ParamFetcher([]);
        $fetcher->getRequiredString('foo');
    }

    public function testGetNullableString(): void
    {
        $fetcher = new ParamFetcher(['foo' => 'bar']);
        $this->assertSame('bar', $fetcher->getNullableString('foo'));
        $this->assertNull($fetcher->getNullableString('baz'));
    }

    public function testGetRequiredInt(): void
    {
        $fetcher = new ParamFetcher(['foo' => 123]);
        $this->assertSame(123, $fetcher->getRequiredInt('foo'));
    }

    public function testGetNullableInt(): void
    {
        $fetcher = new ParamFetcher(['foo' => 123]);
        $this->assertSame(123, $fetcher->getNullableInt('foo'));
        $this->assertNull($fetcher->getNullableInt('baz'));
    }

    public function testGetRequiredBool(): void
    {
        $fetcher = new ParamFetcher(['foo' => true]);
        $this->assertTrue($fetcher->getRequiredBool('foo'));
    }

    public function testGetNullableBool(): void
    {
        $fetcher = new ParamFetcher(['foo' => true]);
        $this->assertTrue($fetcher->getNullableBool('foo'));
        $this->assertNull($fetcher->getNullableBool('baz'));
    }

    public function testGetRequiredDate(): void
    {
        $fetcher = new ParamFetcher(['foo' => '2023-01-01']);
        $date = $fetcher->getRequiredDate('foo', 'Y-m-d');
        $this->assertInstanceOf(\DateTimeImmutable::class, $date);
        $this->assertSame('2023-01-01', $date->format('Y-m-d'));
    }

    public function testGetNullableDate(): void
    {
        $fetcher = new ParamFetcher(['foo' => '2023-01-01']);
        $date = $fetcher->getNullableDate('foo', 'Y-m-d');
        $this->assertInstanceOf(\DateTimeImmutable::class, $date);
        $this->assertSame('2023-01-01', $date->format('Y-m-d'));
        $this->assertNull($fetcher->getNullableDate('baz', 'Y-m-d'));
    }

    public function testFromRequestAttributes(): void
    {
        $request = new Request();
        $request->attributes->set('foo', 'bar');
        $fetcher = ParamFetcher::fromRequestAttributes($request);
        $this->assertSame('bar', $fetcher->getRequiredString('foo'));
    }

    public function testFromRequestBody(): void
    {
        $request = new Request([], ['foo' => 'bar']);
        $fetcher = ParamFetcher::fromRequestBody($request);
        $this->assertSame('bar', $fetcher->getRequiredString('foo'));
    }

    public function testFromRequestQuery(): void
    {
        $request = new Request(['foo' => 'bar']);
        $fetcher = ParamFetcher::fromRequestQuery($request);
        $this->assertSame('bar', $fetcher->getRequiredString('foo'));
    }

    public function testFromRequestApi(): void
    {
        $request = new Request([], [], [], [], [], ['CONTENT_TYPE' => 'application/json'], '{"foo":"bar"}');
        $fetcher = ParamFetcher::fromRequestApi($request);
        $this->assertSame('bar', $fetcher->getRequiredString('foo'));
    }

    public function testAddAndGet(): void
    {
        $fetcher = new ParamFetcher([]);
        $fetcher->add('foo', 'bar');
        $this->assertSame('bar', $fetcher->get('foo'));
    }
}
