<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Pagination;

use ArrayIterator;
use Traversable;

/** @deprecated Use class PaginatedData and DoctrinePaginator */
final class Paginator
{
    public const PAGE_SIZE = 10;

    private Traversable $results;
    private Traversable $items;
    private int $currentPage;
    private int $pageSize;
    private int $numResults;

    public function __construct(mixed $items = [], int $pageSize = self::PAGE_SIZE)
    {
        $this->items = $items instanceof Traversable ? $items : new ArrayIterator($items);
        $this->pageSize = $pageSize;
    }

    public function paginate(int $page = 1): self
    {
        $this->currentPage = max(1, $page);
        $firstResult = ($this->currentPage - 1) * $this->pageSize();
        $lastResult = $firstResult + $this->pageSize();

        $paginated = [];
        $index = 0;
        $count = 0;
        foreach ($this->items as $item) {
            if ($index >= $firstResult && $index < $lastResult) {
                $paginated[] = $item;
                ++$count;
            }
            ++$index;
        }

        $this->results = new ArrayIterator($paginated);
        $this->numResults = $count;

        return $this;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function pageSize(): int
    {
        return $this->pageSize;
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    public function previousPage(): int
    {
        return max(1, $this->currentPage - 1);
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->lastPage();
    }

    public function lastPage(): int
    {
        return (int) ceil($this->numResults / $this->pageSize);
    }

    public function nextPage(): int
    {
        return min($this->lastPage(), $this->currentPage + 1);
    }

    public function hasToPaginate(): bool
    {
        return $this->numResults > $this->pageSize;
    }

    public function numResults(): int
    {
        return $this->numResults;
    }

    public function results(): Traversable
    {
        return $this->results;
    }

    public static function params(array $values, int $page = 1): array
    {
        return [
            'page' => $page,
            'page_size' => (int) (isset($values['n']) && $values['n'] > 0) ? $values['n'] : self::PAGE_SIZE,
            'searching' => $values['b'] ?? '',
        ];
    }
}
