<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use const JSON_ERROR_NONE;
use function Lambdish\Phunctional\filter;
use ReflectionClass;
use RuntimeException;
use const STR_PAD_LEFT;
use Traversable;

final class Helper
{
    public const DATE_FORMAT = 'd-m-Y';

    public static function endsWith(string $needle, string $haystack): bool
    {
        $length = mb_strlen($needle);
        if (0 === $length) {
            return true;
        }

        return mb_substr($haystack, -$length) === $needle;
    }

    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }

    public static function stringToDate(string $date): DateTimeImmutable
    {
        return new DateTimeImmutable($date);
    }

    public static function jsonEncode(array $values): string
    {
        return json_encode($values);
    }

    public static function jsonDecode(string $json): array
    {
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('Unable to parse response body into JSON: '.json_last_error());
        }

        return $data;
    }

    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : mb_strtolower(preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $text));
    }

    public static function toCamelCase(string $text): string
    {
        return lcfirst(str_replace('_', '', ucwords($text, '_')));
    }

    public static function dot(array $array, string $prepend = ''): array
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (\is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend.$key.'.'));
            } else {
                $results[$prepend.$key] = $value;
            }
        }

        return $results;
    }

    public static function filesIn(string $path, string $fileType): array
    {
        return filter(
            static fn (string $possibleModule) => mb_strstr($possibleModule, $fileType),
            scandir($path)
        );
    }

    public static function extractClassName(object $object): string
    {
        $reflect = new ReflectionClass($object);

        return $reflect->getShortName();
    }

    public static function iterableToArray(Traversable $iterable): array
    {
        if (\is_array($iterable)) {
            return $iterable;
        }

        return iterator_to_array($iterable);
    }

    public static function dni(string|int|null $dni): string
    {
        if (null === $dni) {
            return '';
        }

        return str_pad((string) $dni, 8, '0', STR_PAD_LEFT);
    }

    public static function fecha(string|int|null $fecha): ?DateTimeInterface
    {
        if (null === $fecha) {
            return null;
        }

        try {
            return new DateTime((string) $fecha);
        } catch (Exception) {
        }

        return null;
    }

    public static function decimal(mixed $number): ?float
    {
        if (null === $number) {
            return null;
        }

        if (\is_string($number)) {
            $value = str_replace(',', '', $number);

            return is_numeric($value) ? (float) $value : null;
        }

        return (float) $number;
    }

    public static function serialNumber(mixed $number, int $numDigits = 6): ?string
    {
        if (null === $number) {
            return null;
        }

        return str_pad((string) $number, $numDigits, '0', STR_PAD_LEFT);
    }

    public static function cleanUpperText(mixed $text, array $cleanValues = [',', ' ', ';', '.']): ?string
    {
        if (null === $text) {
            return null;
        }

        return mb_strtoupper(str_replace($cleanValues, '', $text));
    }

    public static function months(): array
    {
        return [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Setiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];
    }
}
