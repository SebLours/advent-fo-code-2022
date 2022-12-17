<?php

declare(strict_types=1);

namespace AdventOfCode\Day01;

use AdventOfCode\InputLoader;
use loophp\collection\Contract\Operation\Sortable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day01:2';

    protected static $defaultDescription = 'Day 1 - Answer 2';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day01/input.txt');

        $topThreeCalories = $puzzleInput
            ->map(static fn (string $value): int => (int) $value)
            ->explode(0)
            ->map(static fn (array $window): int => array_sum($window))
            ->sort(Sortable::BY_VALUES, static fn ($left, $right): int => $right <=> $left)
            ->slice(0, 3)
            ->reduce(static fn (int $carry, int $item): int => $carry + $item, 0)
        ;

        $output->writeln(sprintf(
            'The top three Elves carry <options=bold,underscore>%d</> calories',
            $topThreeCalories,
        ));

        return Command::SUCCESS;
    }
}
