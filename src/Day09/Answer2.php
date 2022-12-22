<?php

declare(strict_types=1);

namespace AdventOfCode\Day09;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day09:2';

    protected static $defaultDescription = 'Day 9 - Answer 2';

    public function __construct(
        private readonly MoveLoader $moveLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $moves = $this->moveLoader->load();
        $grid = new Grid();

        $grid->getCell(0, 0)->visitedByTail = true;

        $knots = array_pad([], 10, $grid->getCell(0, 0));

        foreach ($moves as $move) {
            $knots[0] = $grid->move($knots[0], $move);

            foreach (array_slice($knots, 1, null, true) as $key => $knot) {
                if ($grid->getDistance($knots[$key - 1], $knots[$key]) > 1) {
                    $xGap = $knots[$key - 1]->x - $knots[$key]->x;
                    $yGap = $knots[$key - 1]->y - $knots[$key]->y;

                    $knots[$key] = $grid->getCell(
                        $knot->x + max(-1, min(1, $xGap)),
                        $knot->y + max(-1, min(1, $yGap)),
                    );
                }
            }

            $knots[9]->visitedByTail = true;
        }

        $output->writeln(sprintf(
            'There are <options=bold,underscore>%d</> positions visited by the tail',
            $grid->countCellsVisitedByTail(),
        ));

        return Command::SUCCESS;
    }
}
