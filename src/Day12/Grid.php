<?php

declare(strict_types=1);

namespace AdventOfCode\Day12;

use Generator;

final class Grid
{
    private array $cells = [];

    private GridCell $startCell;

    private GridCell $endCell;

    public function __construct(GridCell ...$cells)
    {
        foreach ($cells as $cell) {
            $this->cells[$cell->x][$cell->y] = $cell;

            if ($cell->isStart()) {
                $this->startCell = $cell;
            }

            if ($cell->isEnd()) {
                $this->endCell = $cell;
            }
        }
    }

    public function getStart(): GridCell
    {
        return $this->startCell;
    }

    public function getEndCell(): GridCell
    {
        return $this->endCell;
    }

    public function getCell(int $x, int $y): ?GridCell
    {
        return $this->cells[$x][$y] ?? null;
    }

    public function getNeighbours(GridCell $cell): Generator
    {
        if (isset($this->cells[$cell->x][$cell->y + 1])) {
            yield $this->cells[$cell->x][$cell->y + 1];
        }

        if (isset($this->cells[$cell->x + 1][$cell->y])) {
            yield $this->cells[$cell->x + 1][$cell->y];
        }

        if (isset($this->cells[$cell->x][$cell->y - 1])) {
            yield $this->cells[$cell->x][$cell->y - 1];
        }

        if (isset($this->cells[$cell->x - 1][$cell->y])) {
            yield $this->cells[$cell->x - 1][$cell->y];
        }
    }

    public function getMovableNeighbours(GridCell $cell): Generator
    {
        foreach ($this->getNeighbours($cell) as $neighbour) {
            if ($this->isMoveValid($cell, $neighbour)) {
                yield $neighbour;
            }
        }
    }

    public function isMoveValid(GridCell $from, GridCell $to): bool
    {
        return $from->elevation - 1 <= $to->elevation;
    }

    public function countShortestRoute(callable $isGoal): int
    {
        $this->endCell->distance = 0;
        $route = [$this->endCell];

        while (!empty($route)) {
            $cell = array_shift($route);

            foreach ($this->getMovableNeighbours($cell) as $neighbourCell) {
                if (null !== $neighbourCell->distance) {
                    continue;
                }

                if ($isGoal($neighbourCell)) {
                    return $cell->distance + 1;
                }

                $neighbourCell->distance = $cell->distance + 1;
                array_push($route, $neighbourCell);
            }
        }

        return \PHP_INT_MAX;
    }
}
