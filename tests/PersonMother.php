<?php

declare(strict_types=1);

namespace CarlosChininin\Util\Tests;


use Faker\Factory;

final class PersonMother
{
    private string $name;
    private int $age;
    private bool $isActive;

    public function __construct(string $name, int $age, bool $isActive = true)
    {
        $this->name = $name;
        $this->age = $age;
        $this->isActive = $isActive;
    }

    public static function random(): self
    {
        $faker = Factory::create('es_ES');
        return new self($faker->name, $faker->numberBetween(10,60));
    }

    public function name(): string
    {
        return $this->name;
    }

    public function age(): int
    {
        return $this->age;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}