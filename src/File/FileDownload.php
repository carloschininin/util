<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\File;

use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use function count;
use function is_array;

class FileDownload implements Download
{
    public function down(array|FileDto $files, string $filename = null): Response
    {
        if (is_array($files) && 1 !== count($files)) {
            throw new RuntimeException('Not support');
        }

        $file = $files instanceof FileDto ? $files : $files[0];

        return $this->response($filename ?? $file->name(), $file->path());
    }

    protected function response(string $filename, string $filepath): Response
    {
        $response = new BinaryFileResponse($filepath);
        $response->setContentDisposition(Download::DISPOSITION_ATTACHMENT, $filename);

        return $response;
    }
}
