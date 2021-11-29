<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Filter;

class ValueSearch
{
    public const CONNECTOR_OR = 'OR';
    public const CONNECTOR_AND = 'AND';

    public function __construct(private ?string $searchText = null)
    {
    }

    public function searchText(): ?string
    {
        return $this->searchText;
    }

    public function isSearchTextValid(): bool
    {
        return null !== $this->searchText() && '' !== $this->searchText();
    }
}
