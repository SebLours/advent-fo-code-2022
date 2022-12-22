<?php

declare(strict_types=1);

namespace AdventOfCode\Day09;

final class GridCell
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public bool $visitedByTail = false,
    ) {
    }
}
