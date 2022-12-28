<?php

declare(strict_types=1);

namespace AdventOfCode\Day13;

use loophp\collection\Collection;

final class InputLoader
{
    public function __construct(
        private readonly \AdventOfCode\InputLoader $inputLoader,
    ) {
    }

    public function load(): Collection
    {
        return $this->inputLoader->load('day13/input.txt')
            ->filter()
            ->map(fn (string $input): int|array => json_decode($input))
            ->chunk(2)
        ;
    }
}
