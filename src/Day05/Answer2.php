<?php

declare(strict_types=1);

namespace AdventOfCode\Day05;

use AdventOfCode\InputLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day05:2';

    protected static $defaultDescription = 'Day 5 - Answer 2';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day05/input.txt');

        $puzzleInput = $puzzleInput->explode('');

        $stacks = StacksLoader::load($puzzleInput->first());
        $moves = MoveLoader::load($puzzleInput->last());

        $ship = new Ship9001(...$stacks->all());

        foreach ($moves as $move) {
            $ship->move($move);
        }

        $crates = array_map(fn (Stack $stack): string => $stack->out(), $ship->getStacks());

        $output->writeln(sprintf(
            'There message is <options=bold,underscore>%s</>',
            implode('', $crates),
        ));

        return Command::SUCCESS;
    }
}
