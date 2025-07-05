<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Pagination;

class PaginationException extends \RuntimeException
{
    public function __construct($message = 'Pagination')
    {
        parent::__construct(sprintf('Error: <%s>', $message));
    }
}
