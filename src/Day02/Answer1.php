<?php

declare(strict_types=1);

namespace AdventOfCode\Day02;

use AdventOfCode\InputLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

final class Answer1 extends Command
{
    protected static $defaultName = 'day02:1';

    protected static $defaultDescription = 'Day 2 - Answer 1';

    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $puzzleInput = $this->inputLoader->load('day02/input.txt');

        $score = $puzzleInput
            ->map(fn (string $value): int => $this->createRound($value)->scoreForRight())
            ->reduce(static fn (int $carry, int $item): int => $carry + $item, 0)
        ;

        $output->writeln(sprintf(
            'The total score is <options=bold,underscore>%d</>',
            $score,
        ));

        return Command::SUCCESS;
    }

    private function createRound(string $round): Round
    {
        Assert::notSame(0, preg_match('/([ABC]) ([XYZ])/', $round, $matches));

        return new Round(
            $this->createShape($matches[1]),
            $this->createShape($matches[2]),
        );
    }

    private function createShape(string $letter): Shape
    {
        return match ($letter) {
            'A', 'X' => Shape::Rock,
            'B', 'Y' => Shape::Paper,
            'C', 'Z' => Shape::Scissors,
        };
    }
}
