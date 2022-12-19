<?php

declare(strict_types=1);

namespace AdventOfCode\Day07;

use AdventOfCode\InputLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day07:2';

    protected static $defaultDescription = 'Day 7 - Answer 2';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day07/input.txt');

        $terminal = new Terminal($puzzleInput);

        $diskFree = 70000000 - $terminal->getRootDirectory()->getSize();
        $minimalSize = 30000000 - $diskFree;

        $directories = array_filter(
            $terminal->getRootDirectory()->getAllDirectories(),
            fn (Directory $directory): bool => $directory->getSize() > $minimalSize,
        );

        usort($directories, fn (Directory $left, Directory $right): int => $left->getSize() <=> $right->getSize());

        $output->writeln(sprintf(
            'The total size of the directory is <options=bold,underscore>%d</>',
            (current($directories))->getSize(),
        ));

        return Command::SUCCESS;
    }
}
