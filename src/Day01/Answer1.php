<?php

declare(strict_types=1);

namespace AdventOfCode\Day01;

use AdventOfCode\InputLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day01:1';

    protected static $defaultDescription = 'Day 1 - Answer 1';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day01/input.txt');

        $maxCalories = $puzzleInput
            ->map(static fn (string $value): int => (int) $value)
            ->explode(0)
            ->map(static fn (array $window): int => array_sum($window))
            ->max()
        ;

        $output->writeln(sprintf(
            'The Elf carrying the most calories carries <options=bold,underscore>%d</> calories',
            $maxCalories,
        ));

        return Command::SUCCESS;
    }
}
