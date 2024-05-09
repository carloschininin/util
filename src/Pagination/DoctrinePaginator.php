<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Pagination;

use CarlosChininin\Util\Helper;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\CountWalker;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineOrmPaginator;
use Exception;
use RuntimeException;

/**
 * @template T of object
 */
final class DoctrinePaginator implements PaginatorInterface
{
    /**
     * @param QueryBuilder $data
     * @return PaginatedData<T>
     *
     * @throws Exception
     */
    public function paginate(mixed $data, PaginationDto $pagination): PaginatedData
    {
        if (!$data instanceof QueryBuilder) {
            throw new RuntimeException('Query no valido');
        }

        $limit = $pagination->limit();
        $firstResult = ($pagination->page() - 1) * $limit;
        $query = $data
            ->setFirstResult($firstResult)
            ->setMaxResults($limit)
            ->getQuery();

        if (0 === \count($data->getDQLPart('join'))) {
            $query->setHint(CountWalker::HINT_DISTINCT, false);
        }

        $paginator = new DoctrineOrmPaginator($query, true);

        $useOutputWalkers = \count($data->getDQLPart('having') ?: []) > 0;
        $paginator->setUseOutputWalkers($useOutputWalkers);

        $numResults = $paginator->count();
        $results = Helper::iterableToArray($paginator->getIterator());

        return new PaginatedData($results, $numResults, $pagination);
    }

    public static function filterText(QueryBuilder $query, ?string $searching, array $fields): void
    {
        if (null === $searching) {
            return;
        }

        $texts = explode(' ', trim($searching));
        foreach ($texts as $text) {
            if ('' !== $text) {
                $orX = $query->expr()->orX();
                foreach ($fields as $field) {
                    $orX->add($query->expr()->like($field, $query->expr()->literal('%'.$text.'%')));
                }

                $query = $query->andWhere($orX);
            }
        }
    }

    public static function queryTexts(QueryBuilder $query, array|ParamFetcher $params, array $fields): void
    {
        if ($params instanceof ParamFetcher) {
            $searching = $params->getNullableString('searching');
        } else {
            $searching = $params['searching'] ?? null;
        }

        self::filterText($query, $searching, $fields);
    }
}
