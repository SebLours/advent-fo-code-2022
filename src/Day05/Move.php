<?php

declare(strict_types=1);

namespace AdventOfCode\Day05;

final class Move
{
    public function __construct(
        public readonly int $count,
        public readonly int $from,
        public readonly int $to,
    ) {
    }
}
