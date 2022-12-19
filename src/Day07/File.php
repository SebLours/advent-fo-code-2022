<?php

declare(strict_types=1);

namespace AdventOfCode\Day07;

final class File
{
    public function __construct(
        public readonly string $name,
        public readonly int $size,
    ) {
    }
}
