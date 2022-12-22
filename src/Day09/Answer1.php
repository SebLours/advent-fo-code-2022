<?php

declare(strict_types=1);

namespace AdventOfCode\Day09;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day09:1';

    protected static $defaultDescription = 'Day 9 - Answer 1';

    public function __construct(
        private readonly MoveLoader $moveLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $moves = $this->moveLoader->load();
        $grid = new Grid();

        $head = $tail = $grid->getCell(0, 0);
        $tail->visitedByTail = true;

        foreach ($moves as $move) {
            $previousHead = $head;
            $head = $grid->move($head, $move);

            if ($grid->getDistance($head, $tail) > 1) {
                $tail = $previousHead;
                $tail->visitedByTail = true;
            }
        }

        $output->writeln(sprintf(
            'There are <options=bold,underscore>%d</> positions visited by the tail',
            $grid->countCellsVisitedByTail(),
        ));

        return Command::SUCCESS;
    }
}
