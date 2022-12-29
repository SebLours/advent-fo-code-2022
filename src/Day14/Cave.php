<?php

declare(strict_types=1);

namespace AdventOfCode\Day14;

use LogicException;
use loophp\collection\Collection;
use loophp\collection\Contract\Operation\Sortable;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

final class Cave
{
    /** @var CavePoint[] */
    private array $points = [];

    /** @var CavePoint[] */
    private array $goalLine = [];

    private CavePoint $sourcePoint;

    public function __construct(int $xMin, int $xMax, int $yMax, int $xSource, int $ySource, CavePoint ...$points)
    {
        foreach ($points as $point) {
            $this->addPoint($point);
        }

        $this->sourcePoint = $this->getPoint($xSource, $ySource);
        $this->sourcePoint->type = CavePointType::Source;

        // Add left & right extra air line
        for ($y = 0; $y <= $yMax; ++$y) {
            $this->addPoint(new CavePoint($xMin - 1, $y, CavePointType::Air));
            $this->addPoint(new CavePoint($xMax + 1, $y, CavePointType::Air));
        }

        // Add bottom goal line
        for ($x = $xMin - 1; $x <= $xMax + 1; ++$x) {
            $this->addPoint(new CavePoint($x, $yMax + 1, CavePointType::Goal));
            $this->goalLine[] = $this->getPoint($x, $yMax + 1);
        }
    }

    public function isGoalReached(): bool
    {
        return Collection::fromIterable($this->goalLine)
            ->filter(static fn (CavePoint $point): bool => CavePointType::Sand === $point->type)
            ->count() >= 1
        ;
    }

    public function countSandPoints(): int
    {
        return Collection::fromIterable($this->points)
            ->flatten()
            ->filter(fn (CavePoint $point): bool => !in_array($point, $this->goalLine, true) && CavePointType::Sand === $point->type)
            ->count()
        ;
    }

    public function getPoint(int $x, int $y): ?CavePoint
    {
        return $this->points[$x][$y] ?? null;
    }

    public function getNextFallPoint(CavePoint $point): ?CavePoint
    {
        if ((null !== $nextFallPoint = $this->getPoint($point->x, $point->y + 1)) && $nextFallPoint->isFree()) {
            return $nextFallPoint;
        }

        if ((null !== $nextFallPoint = $this->getPoint($point->x - 1, $point->y + 1)) && $nextFallPoint->isFree()) {
            return $nextFallPoint;
        }

        if ((null !== $nextFallPoint = $this->getPoint($point->x + 1, $point->y + 1)) && $nextFallPoint->isFree()) {
            return $nextFallPoint;
        }

        return null;
    }

    public function makeSandFall(): void
    {
        $point = $this->sourcePoint;

        do {
            $nextPoint = $this->getNextFallPoint($point);
        } while (null !== $nextPoint && $point = $nextPoint);

        $point->type = CavePointType::Sand;
    }

    public function drawLine(CavePoint $from, CavePoint $to, CavePointType $type = CavePointType::Rock): void
    {
        if ($from->x !== $to->x && $from->y !== $to->y) {
            throw new LogicException('Draw diagonal line is not permitted');
        }

        if ($from->x > $to->x || $from->y > $to->y) {
            [$to, $from] = [$from, $to];
        }

        if ($from->x === $to->x) {
            for ($y = $from->y; $y <= $to->y; ++$y) {
                $this->getPoint($from->x, $y)->type = $type;
            }
        } else {
            for ($x = $from->x; $x <= $to->x; ++$x) {
                $this->getPoint($x, $from->y)->type = $type;
            }
        }
    }

    public function asTable(OutputInterface $output): Table
    {
        $points = Collection::fromIterable($this->points)
            ->flatten(1)
            ->sort(Sortable::BY_VALUES, fn (CavePoint $left, CavePoint $right): int => $left->x <=> $right->x)
            ->sort(Sortable::BY_VALUES, fn (CavePoint $left, CavePoint $right): int => $left->y <=> $right->y)
        ;

        $rows = [];

        foreach ($points as $point) {
            $rows[$point->y][$point->x] = $point;
        }

        $headers = array_keys($this->points);
        sort($headers);

        $table = new Table($output);
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->setStyle('borderless');

        return $table;
    }

    private function addPoint(CavePoint $point): void
    {
        $this->points[$point->x][$point->y] = $point;
    }
}
