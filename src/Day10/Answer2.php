<?php

declare(strict_types=1);

namespace AdventOfCode\Day10;

use AdventOfCode\InputLoader;
use Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day10:2';

    protected static $defaultDescription = 'Day 10 - Answer 2';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day10/input.txt');

        $x = null;

        $screen = $puzzleInput
            ->flatMap(static function (string $instruction) use (&$x): Generator {
                if (null === $x) {
                    yield $x = 1;
                }

                yield $x;

                if (str_starts_with($instruction, 'addx')) {
                    yield $x = $x + (int) substr($instruction, 5);
                }
            })
            ->normalize()
            ->map(function (int $x, int $key): string {
                $position = $key % 40;
                $isDarkPixel = $position >= $x - 1 && $position <= $x + 1;

                return $isDarkPixel ? '#' : '.';
            })
            ->limit(240)
            ->chunk(40)
            ->flatMap(fn (array $row): string => implode('', $row))
            ->implode(\PHP_EOL)
        ;

        $output->writeln($screen);

        return Command::SUCCESS;
    }
}
