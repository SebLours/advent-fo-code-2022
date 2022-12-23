<?php

declare(strict_types=1);

namespace AdventOfCode\Day11;

use AdventOfCode\InputLoader;

final class MonkeySquadPart2Loader
{
    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
    }

    public function load(): MonkeySquad
    {
        // Thanks https://github.com/mjpieters/adventofcode/blob/master/2022/Day%2011.ipynb !!!
        $lcm = $this->inputLoader
            ->load('day11/input.txt')
            ->filter()
            ->chunk(6)
            ->map(fn (array $monkey): array => array_slice($monkey, 1))
            ->map(fn (array $monkey): int => (int) substr($monkey[2], 19))
            ->reduce(fn (int $carry, int $divisor): int => $carry * $divisor, 1)
        ;

        $monkeys = $this->inputLoader
            ->load('day11/input.txt')
            ->filter()
            ->chunk(6)
            ->map(fn (array $monkey): array => array_slice($monkey, 1))
            ->map(fn (array $monkey): Monkey => $this->createMonkey($monkey, $lcm))
        ;

        $monkeySquad = new MonkeySquad();

        foreach ($monkeys as $key => $monkey) {
            $monkeySquad->addMonkey($key, $monkey);
        }

        return $monkeySquad;
    }

    private function createMonkey(array $data, int $lcm): Monkey
    {
        preg_match_all('/(\d+)/', $data[0], $matches);

        $items = array_map('intval', $matches[0]);
        $items = array_map(fn (int $item): int => $item, $items);

        $operation = '$item = ' . str_replace('old', '$item', substr($data[1], 17)) . ';';
        $operation = function (int $item) use ($operation, $lcm): int {
            eval($operation);

            return $item % $lcm;
        };

        $divisibleBy = (int) substr($data[2], 19);
        $successMonkey = (int) substr($data[3], 25);
        $failMonkey = (int) substr($data[4], 26);

        $test = function (int $item) use ($divisibleBy, $successMonkey, $failMonkey): int {
            return (0 === $item % $divisibleBy) ? $successMonkey : $failMonkey;
        };

        return new Monkey(
            $items,
            $operation,
            $test,
        );
    }
}
