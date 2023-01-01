<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day15;

use AdventOfCode\Day15\Position;
use PHPUnit\Framework\TestCase;

final class PositionTest extends TestCase
{
    public function test_distance(): void
    {
        $this->assertSame(9, (new Position(8, 7))->distance(new Position(2, 10)));
        $this->assertSame(7, (new Position(2, 18))->distance(new Position(-2, 15)));
    }
}
