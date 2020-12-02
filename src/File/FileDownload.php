<?php

declare(strict_types=1);


namespace CarlosChininin\Util\File;


use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class FileDownload implements Download
{
    public function down(array $files, string $filename = null): Response
    {
        if (1 !== count($files)) {
            throw new RuntimeException('Not support');
        }

        /** @var FileDto $file */
        $file = $files[0];

        return $this->response($filename ?? $file->name(), $file->path());
    }

    protected function response(string $filename, string $filepath): Response
    {
        $response = new BinaryFileResponse($filepath);
        $response->setContentDisposition(Download::DISPOSITION_ATTACHMENT, $filename);

        return $response;
    }
}