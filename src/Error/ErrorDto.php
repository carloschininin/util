<?php

declare(strict_types=1);


namespace CarlosChininin\Util\Error;


final class ErrorDto
{
    private $message;
    private $code;
    private $detail;

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