<?php

declare(strict_types=1);

namespace AdventOfCode\Day11;

use Closure;

final class Monkey
{
    private MonkeySquad $squad;

    private int $inspections = 0;

    public function __construct(
        private array $items,
        private readonly Closure $operation,
        private readonly Closure $test,
    ) {
    }

    public function setSquad(MonkeySquad $squad): void
    {
        $this->squad = $squad;
    }

    public function handleRound(bool $withDivision = true): void
    {
        while (null !== $item = array_shift($this->items)) {
            $this->handleItem($item, $withDivision);
        }
    }

    public function handleItem(int $item, bool $withDivision = true): void
    {
        $item = ($this->operation)($item);

        if ($withDivision) {
            $item = (int) floor($item / 3);
        }

        $this->squad->getMonkey(($this->test)($item))->receiveItem($item);

        ++$this->inspections;
    }

    public function receiveItem(int $item): void
    {
        $this->items[] = $item;
    }

    public function getInspections(): int
    {
        return $this->inspections;
    }
}
