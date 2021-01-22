<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Pagination;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

final class Paginator
{
    public const PAGE_SIZE = 10;

    public static function create(QueryBuilder $query, array $params): Pagerfanta
    {
        $paginator = new Pagerfanta(new QueryAdapter($query));
        $paginator->setMaxPerPage($params['page_size']);
        $paginator->setCurrentPage($params['page']);

        return $paginator;
    }

    public static function params(array $values, int $page = 1): array
    {
        return [
            'page' => $page,
            'page_size' => (int) (isset($values['n']) && $values['n'] > 0) ? $values['n'] : self::PAGE_SIZE,
            'searching' => isset($values['b']) ? $values['b'] : '',
            'active' => isset($values['ac']) ? $values['ac'] : '',
        ];
    }

    public static function queryTexts(QueryBuilder $qb, array $params, array $fields): void
    {
        $searching = trim($params['searching']);
        if ('' !== $searching) {
            $texts = explode(' ', trim($searching));
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
}
