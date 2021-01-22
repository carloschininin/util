<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Helper;

function slugify(string $string): string
{
    return preg_replace('/\s+/', '-', mb_strtolower(trim(strip_tags($string)), 'UTF-8'));
}

function withoutWhiteSpaces(?string $text): string
{
    if (null === $text) {
        return '';
    }

    return str_replace(' ', '', $text);
}

function serialNumber(?string $serial, ?string $number, int $numSerial = 3, int $numNumber = 6): string
{
    if (null === $serial || null === $number) {
        return '';
    }

    return str_pad($serial, $numSerial, '0', STR_PAD_LEFT).'-'.
        str_pad($number, $numNumber, '0', STR_PAD_LEFT);
}
