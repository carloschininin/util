<?php

declare(strict_types=1);


namespace CarlosChininin\Util\File;


use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\String\ByteString;

use ZipArchive;

use function Symfony\Component\String\u;

final class FileZipDownload extends FileDownload
{
    public function down(array $files, string $filename = null): Response
    {
        $filename = $this->generateFileName($filename);
        $fileZip = $this->generateZip($files, $filename);

        return $this->response($filename, $fileZip->path());
    }

    private function generateFileName(?string $fileName): string
    {
        if (null === $fileName) {
            return ByteString::fromRandom(8).'.zip';
        }

        if (false === u($fileName)->endsWith('.zip')) {
            return $fileName.'.zip';
        }

        return $fileName;
    }

    private function generateZip(array $files, string $filename): FileDto
    {
        $zip = new ZipArchive();
        $tempFilename = tempnam(sys_get_temp_dir(), $filename);

        if (true === $zip->open($tempFilename)) { //, ZIPARCHIVE::CREATE
            $tempFiles = [];
            foreach ($files as $file) {
                $path = realpath($file->path());
                if (file_exists($path)) {
                    $newFile = (string) sys_get_temp_dir().'/'.$file->name();
                    copy($path, $newFile);
                    $zip->addFile($newFile, $file->name());
                    $tempFiles[] = $newFile;
                }
            }
            $zip->close();

            // Delete files temp
            foreach ($tempFiles as $tempFile) {
                unlink($tempFile);
            }
        }

        return new FileDto($filename, $tempFilename);
    }
}