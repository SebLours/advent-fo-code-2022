<?php

declare(strict_types=1);

namespace AdventOfCode\Day12;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day12:2';

    protected static $defaultDescription = 'Day 12 - Answer 2';

    public function __construct(
        private readonly GridLoader $gridLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $grid = $this->gridLoader->load();

        $output->writeln(sprintf(
            'There are <options=bold,underscore>%d</> steps required to move from a to end',
            $grid->countShortestRoute(fn (GridCell $cell): bool => 'a' === $cell->letter),
        ));

        return Command::SUCCESS;
    }
}
