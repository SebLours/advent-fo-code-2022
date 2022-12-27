<?php

declare(strict_types=1);

namespace AdventOfCode\Day12;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day12:1';

    protected static $defaultDescription = 'Day 12 - Answer 1';

    public function __construct(
        private readonly GridLoader $gridLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $grid = $this->gridLoader->load();

        $output->writeln(sprintf(
            'There are <options=bold,underscore>%d</> steps required to move from start to end',
            $grid->countShortestRoute(fn (GridCell $cell): bool => $cell->isStart()),
        ));

        return Command::SUCCESS;
    }
}
