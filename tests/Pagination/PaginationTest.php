<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Tests\Pagination;

use CarlosChininin\Util\Pagination\PaginationDto;
use CarlosChininin\Util\Tests\PersonMother;
use PHPUnit\Framework\TestCase;

final class PaginationTest extends TestCase
{
    public function testPaginator(): void
    {
        $data = $this->data(5);
        $paginator = new InMemoryPaginator();
        $paginationData = $paginator->paginate($data, PaginationDto::create(1, 3));
        $this->assertCount(3, $paginationData->results());

        $paginationData = $paginator->paginate($data, PaginationDto::create(2, 3));
        $results = $paginationData->results();
        $this->assertCount(2, $results);

        $this->assertSame($data[3]->name(), $results[0]->name());
        $this->assertFalse($paginationData->hasNextPage());
        $this->assertTrue($paginationData->hasPreviousPage());

        $paginationData = $paginator->paginate($data, PaginationDto::create(3, 3));
        $this->assertEmpty($paginationData->results());
    }

    /**
     * @return PersonMother[]
     */
    private function data(int $numItems = 10): array
    {
        $persons = [];
        for ($i = 1; $i <= $numItems; ++$i) {
            $persons[] = PersonMother::random();
        }

        return $persons;
    }
}
