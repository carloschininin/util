<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util;

use DivisionByZeroError;

class Math
{
    public static function round(?float $value, int $decimal = 2, $mode = \PHP_ROUND_HALF_UP): float
    {
        return round($value, $decimal, $mode);
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
        } catch (DivisionByZeroError) {
        }

        return 0;
    }
}
