<?php

declare(strict_types=1);

namespace Day13;

use AdventOfCode\Day13\Compare;
use PHPUnit\Framework\TestCase;

final class CompareTest extends TestCase
{
    public function test_integers(): void
    {
        $compare = new Compare();

        $this->assertSame(1, $compare(1, 2));
        $this->assertSame(-1, $compare(10, 2));
        $this->assertSame(0, $compare(10, 10));
    }

    public function test_array(): void
    {
        $compare = new Compare();

        $this->assertSame(1, $compare([1,1,3,1,1], [1,1,5,1,1]));
        $this->assertSame(-1, $compare([7,7,7,7], [7,7,7]));
        $this->assertSame(1, $compare([], [3]));
        $this->assertSame(1, $compare([2,3,4], [4]));
        $this->assertSame(-1, $compare([5,6,7], [5,6,0]));
    }

    public function test_mixed(): void
    {
        $compare = new Compare();

        $this->assertSame(1, $compare([[1],[2,3,4]], [[1],4]));
        $this->assertSame(1, $compare([[4,4],4,4], [[4,4],4,4,4]));
        $this->assertSame(-1, $compare([[[]]], [[]]));
        $this->assertSame(1, $compare([[]], [[[]]]));
        $this->assertSame(-1, $compare([1,[2,[3,[4,[5,6,7]]]],8,9], [1,[2,[3,[4,[5,6,0]]]],8,9]));
    }
}
