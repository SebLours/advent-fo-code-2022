<?php

declare(strict_types=1);

namespace AdventOfCode\Day09;

use AdventOfCode\InputLoader;
use Generator;
use loophp\collection\Collection;

final class MoveLoader
{
    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
    }

    public function load(): Collection
    {
        return $this->inputLoader->load('day09/input.txt')
            ->map(static fn (string $move): Move => Move::fromString($move))
            ->flatMap(static function (Move $move): Generator {
                for ($i = 0; $i < $move->count; ++$i) {
                    yield new Move($move->way, 1);
                }
            })
        ;
    }
}
