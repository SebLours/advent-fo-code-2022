<?php

declare(strict_types=1);

namespace AdventOfCode\Day03;

final class LetterPriorityResolver
{
    private array $letters;

    public function __construct()
    {
        $this->letters = array_flip(array_merge(range('a', 'z'), range('A', 'Z')));
    }

    public function priority(string $letter): int
    {
        if (!isset($this->letters[$letter])) {
            return 0;
        }

        return $this->letters[$letter] + 1;
    }
}
