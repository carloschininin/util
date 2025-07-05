<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util;

class Math
{
    private const PHP_VERSION_BCROUND = '8.4.0';

    public static function round(?float $value, int $decimal = 2, $mode = \PHP_ROUND_HALF_UP): float
    {
        return round($value, $decimal, $mode);
    }

    public static function roundMath(float $value, int $decimal): float
    {
        if (self::hasBcroundNative()) {
            return (float) bcround((string) $value, $decimal);
        }

        if (self::hasBcmath()) {
            $multiplier = bcpow('10', (string) $decimal);
            $multiplied = bcmul((string) $value, $multiplier, $decimal + 2);

            return (float) bcdiv(
                bcadd($multiplied, '0.5', 0),
                $multiplier,
                $decimal
            );
        }

        return round($value, $decimal);
    }

    public static function number(?float $value, int $decimal = 2, bool $comma = true): string
    {
        if (false === is_numeric($value)) {
            return '0.00';
        }

        if (true === $comma) {
            return number_format($value, $decimal);
        }

        return number_format($value, $decimal, '.', '');
    }

    public static function percentage(?float $value, ?float $total, int $decimal = 2): float
    {
        if (null === $total || 0.0 === $total) {
            return 0;
        }

        try {
            return round(100 * $value / $total, $decimal, \PHP_ROUND_HALF_DOWN);
        } catch (\DivisionByZeroError) {
        }

        return 0;
    }

    private static function hasBcroundNative(): bool
    {
        return version_compare(PHP_VERSION, self::PHP_VERSION_BCROUND, '>=')
            && extension_loaded('bcmath')
            && function_exists('bcround');
    }

    private static function hasBcmath(): bool
    {
        return extension_loaded('bcmath')
            && function_exists('bcpow');
    }
}
