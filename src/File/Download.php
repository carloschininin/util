<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\File;

use Symfony\Component\HttpFoundation\Response;

interface Download
{
    public const DISPOSITION_ATTACHMENT = 'attachment';
    public const DISPOSITION_INLINE = 'inline';

    public function down(array|FileDto $files, ?string $filename = null): Response;
}
