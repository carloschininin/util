<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Pagination;

interface PaginatorInterface
{
    public function paginate(mixed $data, PaginationDto $pagination): PaginatedData;
}
