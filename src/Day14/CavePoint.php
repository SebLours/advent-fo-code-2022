<?php

declare(strict_types=1);

namespace AdventOfCode\Day14;

use Stringable;

final class CavePoint implements Stringable
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public CavePointType $type,
    ) {
    }

    public function __toString(): string
    {
        return $this->type->value;
    }

    public function isFree(): bool
    {
        return CavePointType::Air === $this->type || CavePointType::Goal === $this->type;
    }
}
