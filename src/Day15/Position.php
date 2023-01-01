<?php

declare(strict_types=1);

namespace AdventOfCode\Day15;

final class Position
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
    ) {
    }

    public function distance(self $position): int
    {
        return abs($this->x - $position->x) + abs($this->y - $position->y);
    }
}
