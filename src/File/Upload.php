<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\File;

interface Upload
{
    /** @param FileDto[] $files */
    public function up(array $files, string $basePath, string $filename = null): bool;
}
