<?php

declare(strict_types=1);

namespace AdventOfCode\Day05;

final class Ship9001
{
    private array $stacks = [];

    public function __construct(Stack ...$stacks)
    {
        foreach ($stacks as $key => $stack) {
            $this->stacks[$key + 1] = $stack;
        }
    }

    public function getStacks(): array
    {
        return $this->stacks;
    }

    public function move(Move $move): void
    {
        $crates = [];

        for ($i = 1; $i <= $move->count; ++$i) {
            $crates[] = $this->stacks[$move->from]->out();
        }

        foreach (array_reverse($crates) as $crate) {
            $this->stacks[$move->to]->in($crate);
        }
    }
}
