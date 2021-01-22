<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\File;

use Symfony\Component\HttpFoundation\File\File;

final class FileDto
{
    private string $name;
    private string $path;
    private ?File $file;

    public function __construct(string $name, string $path, ?File $file = null)
    {
        $this->name = $name;
        $this->path = $path;
        $this->file = $file;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function file(): ?File
    {
        return $this->file;
    }
}
