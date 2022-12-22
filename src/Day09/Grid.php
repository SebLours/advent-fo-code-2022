<?php

declare(strict_types=1);

namespace AdventOfCode\Day09;

use loophp\collection\Collection;

final class Grid
{
    private array $cells = [];

    public function __construct()
    {
        $this->getCell(0, 0);
    }

    public function getCell(int $x, int $y): GridCell
    {
        if (isset($this->cells[$x][$y])) {
            return $this->cells[$x][$y];
        }

        return $this->cells[$x][$y] = new GridCell($x, $y);
    }

    public function move(GridCell $cell, Move $move): GridCell
    {
        return match ($move->way) {
            Way::U => $this->getCell($cell->x, $cell->y + $move->count),
            Way::D => $this->getCell($cell->x, $cell->y - $move->count),
            Way::L => $this->getCell($cell->x - $move->count, $cell->y),
            Way::R => $this->getCell($cell->x + $move->count, $cell->y),
        };
    }

    public function getDistance(GridCell $a, GridCell $b): int
    {
        return max(abs($a->x - $b->x), abs($a->y - $b->y));
    }

    public function countCellsVisitedByTail(): int
    {
        return Collection::fromIterable($this->cells)
            ->flatten(1)
            ->filter(static fn (GridCell $cell): bool => $cell->visitedByTail)
            ->count()
        ;
    }
}
