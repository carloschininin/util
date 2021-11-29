<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Validator;

use DateTimeImmutable;
use Webmozart\Assert\Assert as WebmozartAssert;

abstract class Assert extends WebmozartAssert
{
    public static function dateTimeString(string $value, string $format, string $message = ''): void
    {
        $date = DateTimeImmutable::createFromFormat($format, $value);

        if (false === $date) {
            static::reportInvalidArgument(
                sprintf(
                  '' === $message ? 'Date time string "%s" should be like "%s"' : $message,
                  $value,
                  $format
              ));
        }
    }

    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidDataValidatorException($message);
    }
}
