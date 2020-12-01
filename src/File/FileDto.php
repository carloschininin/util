<?php

declare(strict_types=1);


namespace CarlosChininin\Util\File;


use Symfony\Component\HttpFoundation\File\File;

final class FileDto
{
    private $name;
    private $path;
    private $file;

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