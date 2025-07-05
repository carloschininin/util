<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Http;

use CarlosChininin\Util\Helper;
use CarlosChininin\Util\Validator\Assert;
use Symfony\Component\HttpFoundation\Request;

final class ParamFetcher
{
    private const TYPE_STRING = 'string';
    private const TYPE_INT = 'int';
    private const TYPE_DATE = 'date';
    private const TYPE_BOOL = 'bool';
    private const SCALAR_TYPES = [self::TYPE_STRING, self::TYPE_INT, self::TYPE_BOOL];

    /**
     * @var array<string, mixed>
     */
    private array $data;

    private bool $testScalarType;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data, bool $testScalarType = true)
    {
        $this->data = $data;
        $this->testScalarType = $testScalarType;
    }

    public static function create(array $data, bool $testScalarType = true): self
    {
        return new self($data, $testScalarType);
    }

    public static function fromRequestAttributes(Request $request): self
    {
        return new self($request->attributes->all(), false);
    }

    public static function fromRequestBody(Request $request): self
    {
        return new self($request->request->all());
    }

    public static function fromRequestQuery(Request $request): self
    {
        return new self($request->query->all(), false);
    }

    public static function fromRequestApi(Request $request): self
    {
        if (0 === mb_strpos($request->headers->get('Content-Type'), 'application/json')) {
            $content = json_decode($request->getContent(), true);
            $request->request->replace(\is_array($content) ? $content : []);
        }

        return self::fromRequestBody($request);
    }

    public function getRequiredString(string $key): string
    {
        $this->assertRequired($key);
        $this->assertType($key, self::TYPE_STRING);

        return (string) $this->data[$key];
    }

    public function getNullableString(string $key): ?string
    {
        if (!isset($this->data[$key]) || '' === $this->data[$key]) {
            return null;
        }
        $this->assertType($key, self::TYPE_STRING);

        return (string) $this->data[$key];
    }

    public function getRequiredInt(string $key): int
    {
        $this->assertRequired($key);
        $this->assertType($key, self::TYPE_INT);

        return (int) $this->data[$key];
    }

    public function getNullableInt(string $key): ?int
    {
        if (!isset($this->data[$key]) || '' === $this->data[$key]) {
            return null;
        }
        $this->assertType($key, self::TYPE_INT);

        return (int) $this->data[$key];
    }

    public function getRequiredBool(string $key): bool
    {
        $this->assertRequired($key);
        $this->assertType($key, self::TYPE_BOOL);

        return (bool) $this->data[$key];
    }

    public function getNullableBool(string $key): ?bool
    {
        if (!isset($this->data[$key]) || '' === $this->data[$key]) {
            return null;
        }
        $this->assertType($key, self::TYPE_BOOL);

        return (bool) $this->data[$key];
    }

    /**
     * @throws \Exception
     */
    public function getRequiredDate(string $key, ?string $format = null): \DateTimeImmutable
    {
        $this->assertRequired($key);
        $this->assertType($key, self::TYPE_DATE, $format);

        return new \DateTimeImmutable($this->data[$key]);
    }

    /**
     * @throws \Exception
     */
    public function getNullableDate(string $key, ?string $format = null): ?\DateTimeImmutable
    {
        if (!isset($this->data[$key]) || '' === $this->data[$key]) {
            return null;
        }
        $this->assertType($key, self::TYPE_DATE, $format);

        return new \DateTimeImmutable($this->data[$key]);
    }

    private function assertRequired(string $key): void
    {
        Assert::keyExists($this->data, $key, sprintf('"%s" not found', $key));
        Assert::notNull($this->data[$key], sprintf('"%s" should be not null', $key));
    }

    private function assertType(string $key, string $type, ?string $format = null): void
    {
        if (!$this->testScalarType && \in_array($type, self::SCALAR_TYPES, true)) {
            return;
        }

        match ($type) {
            self::TYPE_STRING => Assert::string($this->data[$key], sprintf('"%s" should be a string. Got %%s', $key)),
            self::TYPE_INT => Assert::string($this->data[$key], sprintf('"%s" should be an integer. Got %%s', $key)),
            self::TYPE_BOOL => Assert::boolean($this->data[$key], sprintf('"%s" should be a boolean. Got %%s', $key)),
            self::TYPE_DATE => Assert::dateTimeString($this->data[$key], $format ?? Helper::DATE_FORMAT, sprintf('"%s" should be a valid format "%s" date', $key, $format ?? Helper::DATE_FORMAT)),
        };
    }

    public function add(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }
}
