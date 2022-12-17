<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day02;

use AdventOfCode\Day02\Round;
use AdventOfCode\Day02\Shape;
use PHPUnit\Framework\TestCase;

final class RoundTest extends TestCase
{
    public function test_score(): void
    {
        $this->assertSame(8, (new Round(Shape::Rock, Shape::Paper))->scoreForRight());
        $this->assertSame(1, (new Round(Shape::Paper, Shape::Rock))->scoreForRight());
        $this->assertSame(6, (new Round(Shape::Scissors, Shape::Scissors))->scoreForRight());
    }
}
