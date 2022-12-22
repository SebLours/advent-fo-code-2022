<?php

declare(strict_types=1);

namespace AdventOfCode\Day10;

use AdventOfCode\InputLoader;
use Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day10:1';

    protected static $defaultDescription = 'Day 10 - Answer 1';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day10/input.txt');

        $x = null;

        $sum = $puzzleInput
            ->flatMap(static function (string $instruction) use (&$x): Generator {
                if (null === $x) {
                    yield $x = 1;
                }

                yield $x;

                if (str_starts_with($instruction, 'addx')) {
                    yield $x = $x + (int) substr($instruction, 5);
                }
            })
            ->chunk(20, 40, 40, 40, 40, 40)
            ->flatMap(static fn (array $chunk, int $key): int => (20 + ($key * 40)) * end($chunk))
            ->limit(6)
            ->reduce(static fn (int $carry, int $item): int => $carry + $item, 0)
        ;

        $output->writeln(sprintf(
            'The sum of these six signal strengths is <options=bold,underscore>%d</>',
            $sum,
        ));

        return Command::SUCCESS;
    }
}
