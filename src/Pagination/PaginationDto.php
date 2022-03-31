<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Pagination;

use CarlosChininin\Util\Validator\Assert;
use Symfony\Component\HttpFoundation\Request;

final class PaginationDto
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_LIMIT = 10;

    public const PAGE_NAME = 'page';
    public const LIMIT_NAME = 'limit';

    private int $page;
    private int $limit;

    private function __construct(int $page, int $limit)
    {
        Assert::greaterThanEq($page, 0);
        Assert::greaterThanEq($limit, 0);

        $this->page = $page;
        $this->limit = $limit;
    }

    public static function create(int $page, ?int $limit = null): self
    {
        return new self($page, $limit ?? self::DEFAULT_LIMIT);
    }

    public static function fromRequest(Request $request): self
    {
        $page = $request->get(self::PAGE_NAME, self::DEFAULT_PAGE);
        Assert::integerish($page);

        $limit = $request->get(self::LIMIT_NAME, self::DEFAULT_LIMIT);
        Assert::integerish($limit);

        return new self((int) $page, (int) $limit);
    }

    public function limit(): int
    {
        return $this->limit > 0 ? $this->limit : self::DEFAULT_LIMIT;
    }

    public function page(): int
    {
        return $this->page > 0 ? $this->page : self::DEFAULT_PAGE;
    }
}
