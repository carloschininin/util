<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\File;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class FileUpload implements Upload
{
    public function up(array $files, string $basePath, ?string $filename = null): bool
    {
        if (1 !== \count($files)) {
            throw new \RuntimeException('Not support');
        }

        /** @var FileDto $file */
        $file = $files[0];
        $fileToUpload = $file->file();

        try {
            $fileToUpload->move($basePath.'/'.$file->path(), $filename ?? $file->name());
        } catch (FileException) {
            return false;
        }

        return true;
    }
}
