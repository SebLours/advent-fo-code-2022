<?php

declare(strict_types=1);

namespace AdventOfCode\Day05;

use Webmozart\Assert\Assert;

final class Ship
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

    public function moveItem(Move $move): void
    {
        Assert::same(1, $move->count);

        $this->stacks[$move->to]->in($this->stacks[$move->from]->out());
    }

    public function move(Move $move): void
    {
        for ($i = 1; $i <= $move->count; ++$i) {
            $this->moveItem(new Move(1, $move->from, $move->to));
        }
    }
}
