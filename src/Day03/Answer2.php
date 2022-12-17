<?php

declare(strict_types=1);

namespace AdventOfCode\Day03;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day03:2';

    protected static $defaultDescription = 'Day 3 - Answer 2';

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
            ->map(fn (string $value): Collection => Collection::fromString($value))
            ->chunk(3)
            ->map(static fn (array $value) => array_map(static fn (Collection $value): array => $value->all(), $value))
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
