<?php

declare(strict_types=1);


namespace CarlosChininin\Util\File;


interface Upload
{
    /** @param FileDto[] $files */
    public function up(array $files, string $filename = null);
}