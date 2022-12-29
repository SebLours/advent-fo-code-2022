<?php

declare(strict_types=1);

namespace AdventOfCode\Day14;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day14:1';

    protected static $defaultDescription = 'Day 14 - Answer 1';

    public function __construct(
        private readonly CaveLoader $caveLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $cave = $this->caveLoader->load(Cave::class);

        while (!$cave->isGoalReached()) {
            $cave->makeSandFall();
        }

        $output->writeln(sprintf(
            'The are <options=bold,underscore>%d</> units of sand come to rest before sand starts flowing into the abyss',
            $cave->countSandPoints(),
        ));

        return Command::SUCCESS;
    }
}
