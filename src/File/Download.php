<?php

declare(strict_types=1);


namespace CarlosChininin\Util\File;


use Symfony\Component\HttpFoundation\Response;

interface Download
{
    const DISPOSITION_ATTACHMENT = 'attachment';
    const DISPOSITION_INLINE = 'inline';

    /** @param FileDto[] $files */
    public function down(array $files, string $filename = null): Response;
}