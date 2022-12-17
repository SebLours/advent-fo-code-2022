<?php

declare(strict_types=1);

namespace AdventOfCode\Day03;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day03:1';

    protected static $defaultDescription = 'Day 3 - Answer 1';

    public function __construct(
        private readonly InputLoader $inputLoader,
        private readonly LetterPriorityResolver $letterPriorityResolver,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day03/input.txt');

        $score = $puzzleInput
            ->map(static fn (string $value): Collection => Collection::fromString($value))
            ->map(static fn (Collection $value): array => array_chunk($value->all(), $value->count() / 2))
            ->map(static fn (array $value): string => current(array_intersect(...$value)))
            ->map(fn (string $value): int => $this->letterPriorityResolver->priority($value))
            ->reduce(static fn (int $carry, int $item): int => $carry + $item, 0)
        ;

        $output->writeln(sprintf(
            'The total score is <options=bold,underscore>%d</>',
            $score,
        ));

        return Command::SUCCESS;
    }
}
