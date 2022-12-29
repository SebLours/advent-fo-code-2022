<?php

declare(strict_types=1);

namespace AdventOfCode\Day14;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;

final class CaveLoader
{
    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
    }

    public function load(string $caveClass): Cave|CaveWithFloor
    {
        $lines = $this->inputLoader
            ->load('day14/input.txt')
            ->distinct()
            ->map(static function (string $input): array {
                return Collection::fromIterable(explode(' -> ', $input))
                    ->flatten()
                    ->map(static fn (string $input): array => explode(',', $input))
                    ->map(static fn (array $input): array => ['x' => (int) $input[0], 'y' => (int) $input[1]])
                    ->window(1)
                    ->slice(1)
                    ->all()
                ;
            })
            ->flatten(1)
            ->all()
        ;

        $lineMarks = Collection::fromIterable($lines)
            ->flatten(1)
            ->all()
        ;

        $xMax = Collection::fromIterable($lineMarks)
            ->map(static fn (array $input): int => $input['x'])
            ->sort()
            ->max()
        ;

        $xMin = Collection::fromIterable($lineMarks)
            ->map(static fn (array $input): int => $input['x'])
            ->sort()
            ->min()
        ;

        $yMax = Collection::fromIterable($lineMarks)
            ->map(static fn (array $input): int => $input['y'])
            ->sort()
            ->max()
        ;

        $points = [];

        for ($y = 0; $y <= $yMax; ++$y) {
            for ($x = $xMin; $x <= $xMax; ++$x) {
                $points[] = new CavePoint($x, $y, CavePointType::Air);
            }
        }

        $cave = new $caveClass($xMin, $xMax, $yMax, 500, 0, ...$points);

        foreach ($lines as $line) {
            $cave->drawLine($cave->getPoint($line[0]['x'], $line[0]['y']), $cave->getPoint($line[1]['x'], $line[1]['y']));
        }

        return $cave;
    }
}
