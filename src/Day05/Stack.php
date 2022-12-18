<?php

declare(strict_types=1);

namespace AdventOfCode\Day05;

use SplDoublyLinkedList;

final class Stack
{
    private SplDoublyLinkedList $crates;

    public function __construct(iterable $crates)
    {
        $this->crates = new SplDoublyLinkedList();
        $this->crates->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);

        foreach ($crates as $crate) {
            $this->crates->push($crate);
        }
    }

    public function getCrates(): SplDoublyLinkedList
    {
        return $this->crates;
    }

    public function out(): string
    {
        return $this->crates->pop();
    }

    public function in(string $letter): void
    {
        $this->crates->push($letter);
    }
}
