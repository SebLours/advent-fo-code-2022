<?php

declare(strict_types=1);

namespace AdventOfCode\Day06;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day06:2';

    protected static $defaultDescription = 'Day 6 - Answer 2';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day06/input.txt');
        $puzzleInput = Collection::fromString($puzzleInput->first());

        $markerDetectedAt = $puzzleInput
            ->window(14 - 1)
            ->until(static fn (array $item): bool => count(array_unique($item)) === 14)
            ->count()
        ;

        $output->writeln(sprintf(
            '<options=bold,underscore>%d</> characters need to be processed before the first start-of-packet marker is detected',
            $markerDetectedAt,
        ));

        return Command::SUCCESS;
    }
}
