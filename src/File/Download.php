<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\File;

use Symfony\Component\HttpFoundation\Response;

interface Download
{
    public const DISPOSITION_ATTACHMENT = 'attachment';
    public const DISPOSITION_INLINE = 'inline';

    /** @param FileDto | array $files */
    public function down($files, string $filename = null): Response;
}
