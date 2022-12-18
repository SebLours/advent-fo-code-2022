<?php

declare(strict_types=1);

namespace AdventOfCode\Day04;

use AdventOfCode\InputLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day04:1';

    protected static $defaultDescription = 'Day 4 - Answer 1';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day04/input.txt');

        $count = $puzzleInput
            ->map(static function (string $value): array {
                preg_match('/(\d+)-(\d+),(\d+)-(\d+)/', $value, $matches);

                return [
                    range($matches[1], $matches[2]),
                    range($matches[3], $matches[4]),
                ];
            })
            ->filter(static function (array $value): bool {
                return
                    $value[0] === array_values(array_intersect(...$value)) ||
                    $value[1] === array_values(array_intersect(...$value))
                ;
            })
            ->count()
        ;

        $output->writeln(sprintf(
            'There are <options=bold,underscore>%d</> assignment pairs does one range fully contain the other',
            $count,
        ));

        return Command::SUCCESS;
    }
}
