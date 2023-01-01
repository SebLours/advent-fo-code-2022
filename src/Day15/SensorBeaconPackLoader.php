<?php

declare(strict_types=1);

namespace AdventOfCode\Day15;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;

final class SensorBeaconPackLoader
{
    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
    }

    public function load(): Collection
    {
        return $this->inputLoader
            ->load('day15/input.txt')
            ->map(static function (string $input): SensorBeaconPack {
                preg_match_all('/x=(-?\d+), y=(-?\d+)/', $input, $matches);

                $sensor = new Position((int) $matches[1][0], (int) $matches[2][0]);
                $beacon = new Position((int) $matches[1][1], (int) $matches[2][1]);

                return new SensorBeaconPack($sensor, $beacon, $sensor->distance($beacon));
            })
        ;
    }
}
