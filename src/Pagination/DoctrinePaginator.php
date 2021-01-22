<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Pagination;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\CountWalker;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineOrmPaginator;

final class DoctrinePaginator extends Paginator
{
    private QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder, int $pageSize = self::PAGE_SIZE)
    {
        $this->queryBuilder = $queryBuilder;
        parent::__construct([], $pageSize);
    }

    public function paginate(int $page = 1): self
    {
        $this->currentPage = max(1, $page);
        $firstResult = ($this->currentPage - 1) * $this->pageSize;

        $query = $this->queryBuilder
            ->setFirstResult($firstResult)
            ->setMaxResults($this->pageSize)
            ->getQuery();

        if (0 === \count($this->queryBuilder->getDQLPart('join'))) {
            $query->setHint(CountWalker::HINT_DISTINCT, false);
        }

        $paginator = new DoctrineOrmPaginator($query, true);

        $useOutputWalkers = \count($this->queryBuilder->getDQLPart('having') ?: []) > 0;
        $paginator->setUseOutputWalkers($useOutputWalkers);

        try {
            $this->results = $paginator->getIterator();
        } catch (\Exception $e) {
            throw new PaginationException();
        }

        $this->numResults = $paginator->count();

        return $this;
    }

    public static function queryTexts(QueryBuilder $qb, array $params, array $fields): void
    {
        $searching = isset($params['searching']) ? trim($params['searching']) : '';
        if ('' === $searching) {
            return;
        }

        $texts = explode(' ', $searching);
        foreach ($texts as $t) {
            if ('' !== $t) {
                $orX = $qb->expr()->orX();
                foreach ($fields as $field) {
                    $orX->add($qb->expr()->like($field, $qb->expr()->literal('%'.$t.'%')));
                }

                $qb = $qb->andWhere($orX);
            }
        }
    }
}
