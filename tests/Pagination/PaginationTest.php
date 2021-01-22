<?php

declare(strict_types=1);


namespace CarlosChininin\Util\Tests\Pagination;


use CarlosChininin\Util\Pagination\Paginator;
use CarlosChininin\Util\Tests\PersonMother;
use PHPUnit\Framework\TestCase;

final class PaginationTest extends TestCase
{
    public function testPaginator(): void
    {
        $data = $this->data(5);
        $paginator = new Paginator($data,3);
        $paginator->paginate(1);
        $this->assertCount(3, $paginator->results());

        $paginator->paginate(2);
        $result = $paginator->results();
        $this->assertCount(2, $result);
        $this->assertEquals(2, $paginator->numResults());
        $this->assertSame($data[3]->name(), $result[0]->name());
        $this->assertFalse($paginator->hasNextPage());
        $this->assertTrue($paginator->hasPreviousPage());

        $paginator->paginate(3);
        $this->assertEmpty($paginator->results());
    }

    /**
     * @return PersonMother[]
     */
    private function data(int $numItems = 10): array
    {
        $persons = [];
        for ($i = 1; $i <= $numItems; $i++) {
            $persons[] = PersonMother::random();
        }

        return $persons;
    }
}