<?php

declare(strict_types=1);

namespace AdventOfCode\Day02;

enum RoundResult
{
    case Win;
    case Draw;
    case Loose;

    public function score(): int
    {
        return match ($this) {
            self::Win => 6,
            self::Draw => 3,
            self::Loose => 0,
        };
    }
}
