<?php

declare(strict_types=1);

namespace AdventOfCode\Day11;

final class MonkeySquad
{
    public function __construct(
        private array $monkeys = [],
    ) {
    }

    public function addMonkey(int $key, Monkey $monkey): void
    {
        $monkey->setSquad($this);
        $this->monkeys[$key] = $monkey;
    }

    public function getMonkey(int $key): Monkey
    {
        return $this->monkeys[$key];
    }

    public function handleRound(bool $withDivision = true): void
    {
        foreach ($this->monkeys as $monkey) {
            $monkey->handleRound($withDivision);
        }
    }

    public function getMonkeys(): array
    {
        return $this->monkeys;
    }

    public function getBusinessLevel(): int
    {
        $levels = array_map(fn (Monkey $monkey): int => $monkey->getInspections(), $this->monkeys);
        sort($levels);
        $levels = array_slice($levels, -2);

        return array_reduce($levels, fn (int $carry, int $level): int => $carry * $level, 1);
    }
}
