<?php

declare(strict_types=1);

namespace AdventOfCode\Day07;

use AdventOfCode\InputLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day07:1';

    protected static $defaultDescription = 'Day 7 - Answer 1';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day07/input.txt');

        $terminal = new Terminal($puzzleInput);

        $size = $terminal->getRootDirectory()->getDirectoriesTotalSizeWithAtMost(100000);

        $output->writeln(sprintf(
            'The sum of the total sizes of directories is <options=bold,underscore>%d</>',
            $size,
        ));

        return Command::SUCCESS;
    }
}
