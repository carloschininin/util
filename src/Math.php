<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Math;

function round(?float $value, int $decimal = 2): float
{
    return round($value, $decimal);
}

function number(?float $value, int $decimal = 2, bool $comma = true): string
{
    if (false === is_numeric($value)) {
        return '0';
    }

    if (true === $comma) {
        return number_format($value, $decimal);
    }

    return number_format($value, $decimal, '.', ''); //sin separador de miles ,
}

function percentage(?float $value, ?float $total, int $decimal = 2): float
{
    if (null === $total) {
        return 0;
    }

    return round(100 * $value / $total);
}
