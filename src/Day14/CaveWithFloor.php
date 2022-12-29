<?php

declare(strict_types=1);

namespace AdventOfCode\Day14;

use LogicException;
use loophp\collection\Collection;

final class CaveWithFloor
{
    /** @var CavePoint[] */
    private array $points = [];

    private CavePoint $sourcePoint;

    private int $yMax;

    public function __construct(int $xMin, int $xMax, int $yMax, int $xSource, int $ySource, CavePoint ...$points)
    {
        $this->yMax = $yMax;

        foreach ($points as $point) {
            $this->addPoint($point);
        }

        $this->sourcePoint = $this->getPoint($xSource, $ySource);
        $this->sourcePoint->type = CavePointType::Source;
    }

    public function isGoalReached(): bool
    {
        return CavePointType::Sand === $this->sourcePoint->type;
    }

    public function countSandPoints(): int
    {
        return Collection::fromIterable($this->points)
            ->flatten()
            ->filter(fn (CavePoint $point): bool => CavePointType::Sand === $point->type)
            ->count()
        ;
    }

    public function getPoint(int $x, int $y): CavePoint
    {
        if (!isset($this->points[$x][$y])) {
            $this->points[$x][$y] = new CavePoint($x, $y, $y !== $this->yMax + 2 ? CavePointType::Air : CavePointType::Rock);
        }

        return $this->points[$x][$y];
    }

    public function getNextFallPoint(CavePoint $point): ?CavePoint
    {
        if (($nextFallPoint = $this->getPoint($point->x, $point->y + 1)) && $nextFallPoint->isFree()) {
            return $nextFallPoint;
        }

        if (($nextFallPoint = $this->getPoint($point->x - 1, $point->y + 1)) && $nextFallPoint->isFree()) {
            return $nextFallPoint;
        }

        if (($nextFallPoint = $this->getPoint($point->x + 1, $point->y + 1)) && $nextFallPoint->isFree()) {
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

    private function addPoint(CavePoint $point): void
    {
        $this->points[$point->x][$point->y] = $point;
    }
}
