<?php

declare(strict_types=1);


namespace CarlosChininin\Util\File;


use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class FileDownload implements Download
{
    public function down(array $files, string $filename)
    {
        if (1 !== \count($files)) {
            throw new \RuntimeException('Not support');
        }

        $file = $files[0];
        $response = new BinaryFileResponse($file->path());
        $response->setContentDisposition(Download::DISPOSITION_ATTACHMENT, $filename);

        return $response;
    }
}