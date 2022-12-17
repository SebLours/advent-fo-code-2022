<?php

declare(strict_types=1);

namespace AdventOfCode\Day02;

final class Round
{
    public function __construct(
        private readonly Shape $leftShape,
        private readonly Shape $rightShape,
    ) {
    }

    public function scoreForLeft(): int
    {
        return $this->leftShape->score() + $this->leftShape->fightWith($this->rightShape)->score();
    }

    public function scoreForRight(): int
    {
        return $this->rightShape->score() + $this->rightShape->fightWith($this->leftShape)->score();
    }
}
