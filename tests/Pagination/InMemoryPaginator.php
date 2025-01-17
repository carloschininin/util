<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Tests\Pagination;

use CarlosChininin\Util\Pagination\PaginatedData;
use CarlosChininin\Util\Pagination\PaginationDto;
use CarlosChininin\Util\Pagination\PaginatorInterface;

final class InMemoryPaginator implements PaginatorInterface
{
    public function paginate(mixed $data, PaginationDto $pagination, bool $evaluate = false): PaginatedData
    {
        $currentPage = max(1, $pagination->page());
        $firstResult = ($currentPage - 1) * $pagination->limit();
        $lastResult = $firstResult + $pagination->limit();

        $paginated = [];
        $index = 0;
        $count = 0;
        foreach ($data as $item) {
            if ($index >= $firstResult && $index < $lastResult) {
                $paginated[] = $item;
                ++$count;
            }
            ++$index;
        }

        return new PaginatedData($paginated, $count, $pagination);
    }
}
