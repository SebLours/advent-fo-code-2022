<?php

declare(strict_types=1);

namespace AdventOfCode\Day13;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day13:1';

    protected static $defaultDescription = 'Day 13 - Answer 1';

    public function __construct(
        private readonly InputLoader $inputLoader,
        private readonly Compare $compare,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sum = $this->inputLoader->load()
            ->map(fn (array $input): int => ($this->compare)($input[0], $input[1]))
            ->map(static fn (int $result, int $key): int => 1 === $result ? $key + 1 : 0)
            ->reduce(static fn (int $carry, int $item): int => $carry + $item, 0)
        ;

        $output->writeln(sprintf(
            'The sum the indices of those pairs is <options=bold,underscore>%d</>',
            $sum,
        ));

        return Command::SUCCESS;
    }
}
