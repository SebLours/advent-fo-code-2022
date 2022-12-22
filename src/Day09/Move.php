<?php

declare(strict_types=1);

namespace AdventOfCode\Day09;

final class Move
{
    public function __construct(
        public readonly Way $way,
        public readonly int $count,
    ) {
    }

    public static function fromString(string $move): self
    {
        return new self(Way::from(substr($move, 0, 1)), (int) substr($move, 2));
    }
}
