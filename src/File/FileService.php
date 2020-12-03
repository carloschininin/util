<?php

declare(strict_types=1);


namespace CarlosChininin\Util\File;


use Symfony\Component\HttpFoundation\Response;

final class FileService
{
    private $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(FileDto $fileDto): bool
    {
        $fileUpload = new FileUpload();

        return $fileUpload->up([$fileDto], $this->targetDirectory());
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
        $filePath =$this->targetDirectory().$this->filePath($fileDto);
        if ($this->fileExists($filePath)) {
            return false;
        }

        $this->fileRemove($filePath);
        return true;
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

    private function fileRemove(string $filePath): bool
    {
        return unlink($filePath);
    }
}