<?php

declare(strict_types=1);

namespace AdventOfCode\Day06;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day06:1';

    protected static $defaultDescription = 'Day 6 - Answer 1';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day06/input.txt');
        $puzzleInput = Collection::fromString($puzzleInput->first());

        $accumulator = [];

        foreach ($puzzleInput as $key => $letter) {
            $accumulator[] = $letter;

            if (count(array_unique(array_slice($accumulator, -4))) === 4) {
                break;
            }
        }

        $output->writeln(sprintf(
            '<options=bold,underscore>%d</> characters need to be processed before the first start-of-packet marker is detected',
            $key + 1,
        ));

        return Command::SUCCESS;
    }
}
