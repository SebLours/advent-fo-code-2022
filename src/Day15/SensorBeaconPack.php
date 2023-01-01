<?php

declare(strict_types=1);

namespace AdventOfCode\Day15;

final class SensorBeaconPack
{
    public function __construct(
        public readonly Position $sensor,
        public readonly Position $beacon,
        public readonly int $distance,
    ) {
    }
}
