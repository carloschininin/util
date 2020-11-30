<?php

declare(strict_types=1);


namespace CarlosChininin\Util\File;


interface Download
{
    const DISPOSITION_ATTACHMENT = 'attachment';
    const DISPOSITION_INLINE = 'inline';

    /** @param File[] $files */
    public function down(array $files, string $filename);
}