<?php

declare(strict_types=1);

namespace AdventOfCode\Day05;

use loophp\collection\Collection;

final class MoveLoader
{
    public static function load(iterable $input): Collection
    {
        return Collection::fromIterable($input)
            ->map(static function (string $value): Move {
                preg_match('/move (\d+) from (\d+) to (\d+)/', $value, $matches);

                return new Move((int) $matches[1], (int) $matches[2], (int) $matches[3]);
            })
        ;
    }
}
