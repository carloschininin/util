<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\File;

use Symfony\Component\HttpFoundation\Response;

final class FileService
{
    public function __construct(private string $targetDirectory)
    {
    }

    public function upload(FileDto $fileDto): bool
    {
        return (new FileUpload())->up([$fileDto], $this->targetDirectory());
    }

    public function download(FileDto $fileDto, ?string $fileName = null): Response
    {
        $fileDownload = new FileDownload();

        return $fileDownload->down([$fileDto], $fileName);
    }

    /** @param FileDto[] $files */
    public function downloadZip(array $files, string $fileName): Response
    {
        $fileZipDownload = new FileZipDownload();

        return $fileZipDownload->down($files, $fileName);
    }

    public function remove(FileDto $fileDto): bool
    {
        $filePath = $this->targetDirectory().$this->filePath($fileDto);

        return $this->fileRemove($filePath);
    }

    public function targetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function filePath(FileDto $fileDto): string
    {
        return $fileDto->path().$fileDto->name();
    }

    private function fileExists(string $filePath): bool
    {
        return file_exists($filePath);
    }

    public function fileRemove(string $filePath): bool
    {
        if ($this->fileExists($filePath)) {
            return false;
        }

        return unlink($filePath);
    }
}
