<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Error;

final class ErrorDto
{
    private string $message;
    private int $code;
    private ?string $detail;

    public function __construct(string $message, int $code, ?string $detail = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->detail = $detail;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function code(): int
    {
        return $this->code;
    }

    public function detail(): ?string
    {
        return $this->detail;
    }
}
