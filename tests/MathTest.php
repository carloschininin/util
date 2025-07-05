<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\Util\Tests;

use CarlosChininin\Util\Math;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    public function testRound(): void
    {
        $this->assertSame(10.56, Math::round(10.555));
        $this->assertSame(10.55, Math::round(10.554));
        $this->assertSame(10.6, Math::round(10.555, 1));
    }

    public function testRoundMath(): void
    {
        $this->assertSame(10.987656, Math::roundMath(10.9876555, 6));
        $this->assertSame(10.987655, Math::roundMath(10.9876554, 6));
        $this->assertSame(10.98766, Math::roundMath(10.9876555, 5));
    }

    public function testNumber(): void
    {
        $this->assertSame('10.56', Math::number(10.555));
        $this->assertSame('10.55', Math::number(10.554));
        $this->assertSame('10.60', Math::number(10.6));
        $this->assertSame('10.00', Math::number(10.0));
        $this->assertSame('0.00', Math::number(null));
        $this->assertSame('1,000.56', Math::number(1000.555, 2, true));
    }

    public function testPercentage(): void
    {
        $this->assertSame(50.0, Math::percentage(50, 100));
        $this->assertSame(33.33, Math::percentage(1, 3));
        $this->assertSame(0.0, Math::percentage(100, 0));
        $this->assertSame(0.0, Math::percentage(100, null));
    }
}
