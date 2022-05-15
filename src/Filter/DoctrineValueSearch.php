<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Filter;

use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\QueryBuilder;

class DoctrineValueSearch extends ValueSearch
{
    public function text(QueryBuilder $queryBuilder, array $fields, string $connector = self::CONNECTOR_OR): void
    {
        if (!$this->isSearchTextValid()) {
            return;
        }

        $expression = $queryBuilder->expr();
        $separedWords = explode(' ', trim($this->searchText()));

        $connectorQuery = self::CONNECTOR_OR === $connector ? $expression->orX() : $expression->andX();
        foreach ($separedWords as $word) {
            if ('' === $word) {
                continue;
            }

            foreach ($fields as $field) {
                $connectorQuery->add($expression->like($field, $expression->literal('%'.$word.'%')));
            }

            $queryBuilder = $queryBuilder->andWhere($connectorQuery);
        }
    }

    public static function apply(QueryBuilder $queryBuilder, ?string $textSearch, array $fields, string $connector = self::CONNECTOR_OR): void
    {
        if (null === $textSearch) {
            return;
        }

        (new self($textSearch))->text($queryBuilder, $fields, $connector);
    }

    public static function byParams(QueryBuilder $queryBuilder, ParamFetcher $params, array $fields, string $connector = self::CONNECTOR_OR): void
    {
        $textSearch = $params->getNullableString('searching') ?? $params->getNullableString('b');

        self::apply($queryBuilder, $textSearch, $fields, $connector);
    }
}
