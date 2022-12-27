<?php

declare(strict_types=1);

namespace AdventOfCode\Day12;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;

final class GridLoader
{
    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
    }

    public function load(): Grid
    {
        $cells = $this->inputLoader
            ->load('day12/input.txt')
            ->map(fn (string $input): Collection => Collection::fromString($input))
            ->map(function (Collection $line, int $y): array {
                return $line
                    ->map(fn (string $letter, int $x): GridCell => $this->createGridCell($x, $y, $letter))
                    ->all()
                ;
            })
            ->flatten()
            ->all()
        ;

        return new Grid(...$cells);
    }

    private function createGridCell(int $x, int $y, string $letter): GridCell
    {
        static $elevations = [];

        if (empty($elevations)) {
            $elevations = array_flip(range('a', 'z'));
            $elevations['S'] = 0;
            $elevations['E'] = 25;
        }

        return new GridCell($x, $y, $letter, $elevations[$letter]);
    }
}
