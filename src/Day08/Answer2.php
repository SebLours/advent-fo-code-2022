<?php

declare(strict_types=1);

namespace AdventOfCode\Day08;

use loophp\collection\Collection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day08:2';

    protected static $defaultDescription = 'Day 8 - Answer 2';

    public function __construct(
        private readonly FileLocator $dataFileLocator,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $grid = Collection::fromString(file_get_contents($this->dataFileLocator->locate('day08/input.txt')))
            ->explode(\PHP_EOL)
            ->all()
        ;

        $maxScore = 1;

        for ($y = 1; $y < count($grid) - 1; ++$y) {
            for ($x = 1; $x < count($grid) - 1; ++$x) {
                $score = $this->getTreeScore($this->getTreeLines($grid, $x, $y), (int) $grid[$y][$x]);

                if ($score > $maxScore) {
                    $maxScore = $score;
                }
            }
        }

        $output->writeln(sprintf(
            'The highest scenic score possible is <options=bold,underscore>%d</>',
            $maxScore,
        ));

        return Command::SUCCESS;
    }

    private function getTreeLines(array $grid, int $x, int $y): array
    {
        $up = $down = [];

        for ($i = 0; $i < count($grid); ++$i) {
            if ($i === $y) {
                continue;
            }

            if ($i < $y) {
                $up[] = (int) $grid[$i][$x];
            } else {
                $down[] = (int) $grid[$i][$x];
            }
        }

        $left = $right = [];

        for ($i = 0; $i < count($grid); ++$i) {
            if ($i === $x) {
                continue;
            }

            if ($i < $x) {
                $left[] = (int) $grid[$y][$i];
            } else {
                $right[] = (int) $grid[$y][$i];
            }
        }

        $up = array_reverse($up);
        $left = array_reverse($left);

        return compact('up', 'down', 'left', 'right');
    }

    private function getTreeScore(array $lines, int $tree): int
    {
        return
            $this->getTreeLineScore($lines['up'], $tree)
            * $this->getTreeLineScore($lines['down'], $tree)
            * $this->getTreeLineScore($lines['left'], $tree)
            * $this->getTreeLineScore($lines['right'], $tree)
        ;
    }

    private function getTreeLineScore(array $line, int $tree): int
    {
        foreach ($line as $key => $size) {
            if ($size >= $tree) {
                return $key + 1;
            }
        }

        return count($line);
    }
}
