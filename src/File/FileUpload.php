<?php

declare(strict_types=1);


namespace CarlosChininin\Util\File;


use RuntimeException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FileUpload implements Upload
{
    public function up(array $files, string $basePath, string $filename = null): bool
    {
        if (1 !== count($files)) {
            throw new RuntimeException('Not support');
        }

        /** @var FileDto $file */
        $file = $files[0];
        $fileToUpload = $file->file();
        if (!$fileToUpload instanceof UploadedFile) {
            throw new RuntimeException('Not support format file');
        }

        try {
            $fileToUpload->move($basePath.$file->path(), $filename ?? $file->name());
        } catch (FileException $exception) {
            return false;
        }

        return true;
    }
}