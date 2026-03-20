# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Install dependencies
composer install

# Run all tests
./vendor/bin/phpunit

# Run a single test file
./vendor/bin/phpunit tests/Http/ParamFetcherTest.php

# Run a single test method
./vendor/bin/phpunit --filter testMethodName

# Fix code style
./vendor/bin/php-cs-fixer fix

# Check code style without fixing
./vendor/bin/php-cs-fixer fix --dry-run
```

## Architecture

This is a PHP 8.4+ utility library (`CarlosChininin\Util`) providing reusable components for Symfony/Doctrine applications.

### Key modules

- **`Helper`** / **`Math`** — Static utility methods for strings, dates, JSON, case conversion, and math operations.
- **`Http\ParamFetcher`** — Wraps a Symfony `Request` to extract typed parameters (string, int, date, bool) with defaults and validation.
- **`Pagination\`** — `PaginatorInterface` with a generic `Paginator`, a `DoctrinePaginator` backed by Doctrine ORM, and `PaginatedData`/`PaginationDto` DTOs. Tests use `InMemoryPaginator` to avoid database dependencies.
- **`File\`** — File upload/download services; `FileZipDownload` for ZIP archives. Uses Symfony `HttpFoundation` for responses.
- **`Filter\DoctrineValueSearch`** — Integrates search/filter logic with Doctrine queries.
- **`Validator\Assert`** — Extends `Webmozart\Assert` with custom assertions. `UserValidator` provides user-specific validation rules.
- **`Error\`** — `Error` and `ErrorDto` for structured error representation.

### Conventions

- All source files declare `strict_types=1` and include the PIDIA copyright header (enforced by PHP CS Fixer).
- Code style follows the Symfony ruleset (`.php-cs-fixer.dist.php`).
- Tests use the Object Mother pattern (`PersonMother`) with FakerPHP (`es_ES` locale) to generate fixtures.
- No database is required for tests — Doctrine-dependent code is tested via in-memory fakes.
