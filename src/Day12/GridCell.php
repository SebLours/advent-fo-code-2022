<?php

declare(strict_types=1);

namespace AdventOfCode\Day12;

use Stringable;

final class GridCell implements Stringable
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly string $letter,
        public readonly int $elevation,
        public ?int $distance = null,
    ) {
    }

    public function __toString(): string
    {
        return sprintf('%s - %d - %d,%d', $this->letter, $this->elevation, $this->x, $this->y);
    }

    public function isStart(): bool
    {
        return 'S' === $this->letter;
    }

    public function isEnd(): bool
    {
        return 'E' === $this->letter;
    }
}
